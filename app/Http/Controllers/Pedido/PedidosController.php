<?php

namespace App\Http\Controllers\Pedido;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PedidosController extends Controller
{
    public function index(Request $req)
    {
        // Validar las fechas de entrada
        // Validar las fechas de entrada
        $validator = Validator::make($req->all(), [
            'desde' => 'nullable|date_format:Y-m-d',
            'hasta' => 'nullable|date_format:Y-m-d'
        ]);
        if ($validator->fails())
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 400);

        // Utilizar Carbon para manejar las fechas

        $desde = $req->desde ? Carbon::parse($req->desde) : Carbon::now();
        $hasta = $req->hasta ? Carbon::parse($req->hasta) : Carbon::now();


        $pedidos = Pedido::whereBetween('pedidos.created_at', [$desde->startOfDay(), $hasta->endOfDay()])
            ->with([
                'formasPagoPedido',
                'items.producto',
                'items.impuesto',
            ])
            ->join('clientes', 'pedidos.cliente_id', '=', 'clientes.id')
            ->select(
                'pedidos.total',
                'pedidos.id',
                'pedidos.estado',
                'pedidos.tipo',
                'pedidos.created_at',
                'pedidos.descuento',
                'pedidos.importe_final',
                'clientes.razon_social',
                'clientes.doc'
            )
            ->orderBy('pedidos.created_at', 'desc')
            ->get();

        // Luego, transforma los datos para el JSON de respuesta
        $pedidosFormateados = $pedidos->map(function ($pedido) {
            // Mantén los datos originales del pedido
            $resultado = $pedido->toArray();

            // Reformatea los items
            $resultado['items'] = $pedido->items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nombre' => $item->producto->nombre,
                    'codigo' => $item->producto->codigo,
                    'cantidad' => $item->cantidad,
                    'precio' => $item->precio,
                    'impuesto_id' => $item->impuesto_id,
                    'impuesto_descripcion' => $item->impuesto->descripcion,
                    'impuesto_valor' => $item->impuesto->valor,
                ];
            });

            return $resultado;
        });
        return response()->json([
            'success' => true,
            'message' => 'Pedidos obtenidos correctamente',
            'results' => $pedidosFormateados
        ]);
    }





    public function find($id)
    {
        $pedido = Pedido::with('items')->find($id);
        if (!$pedido)
            return response()->json(['success' => false, 'message' => 'Pedido no encontrado'], 404);
        return response()->json(['success' => true, 'results' => $pedido], 200);
    }

    public function crearPedidoEnMostrador(Request $req)
    {
        // Validar los datos de entrada
        $validatorPedido = Validator::make($req->all(), [
            //'cliente_id' => 'required|exists:clientes,id',
            'formas_pagos' => 'required|array',
            'formas_pagos.*.id' => 'required|exists:formas_pagos,id',
            'formas_pagos.*.monto' => 'required|numeric|min:0',
            'formas_pagos.*.abreviatura' => 'required|string',
            'moneda_id' => 'required|exists:monedas,id',
            'aplicar_impuesto' => 'required|boolean',
            'tipo' => 'required',
            'entregado' => 'required|boolean',
            'porcentaje_descuento' => 'required|numeric|min:0',
            'descuento' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'items' => 'required|array',
            'items.*.producto_id' => 'required|exists:productos,id',
            'items.*.impuesto_id' => 'required|exists:impuestos,id',
            'items.*.deposito_id' => 'required|exists:depositos,id',
            'items.*.cantidad' => 'required|numeric|min:1',
            'items.*.precio' => 'required|numeric|min:0',
            'items.*.descuento' => 'required|numeric|min:0',
            'items.*.total' => 'required|numeric|min:0',
        ]);

        if ($validatorPedido->fails())
            return response()->json(['success' => false, 'message' => $validatorPedido->errors()->first()], 400);
        $importe_final = ($req->total - $req->descuento);
        $sumaPagos = array_sum(array_column($req->formas_pagos, 'monto'));
        if ($sumaPagos < $importe_final && $req->tipo === 0)
            return response()->json(['success' => false, 'message' => 'El pago es menor al total del pedido'], 400);


        DB::beginTransaction();
        try {
            $user = auth()->user();
            $datas = [
                'user_id' => $user->id,
                'moneda_id' => $req->moneda_id,
                'cliente_id' => $req->cliente_id === 0 ? 1 : $req->cliente_id,
                'aplicar_impuesto' => $req->aplicar_impuesto,
                'tipo' => $req->tipo,
                'porcentaje_descuento' => $req->porcentaje_descuento,
                'descuento' => $req->descuento,
                'total' => $req->total,
                'importe_final' => $importe_final,
                'estado' => $req->entregado ? 3 : 1
            ];

            $pedido = Pedido::create($datas);
            foreach ($req->items as $item) {
                $pedido->items()->create([
                    'producto_id' => $item['producto_id'],
                    'impuesto_id' => $item['impuesto_id'],
                    'deposito_id' => $item['deposito_id'],
                    'cantidad' => $item['cantidad'],
                    'precio' => $item['precio'],
                    'descuento' => $item['descuento'],
                    'total' => $item['total'],
                ]);
            }
            foreach ($req->formas_pagos as $formaPago) {
                $pedido->formasPagoPedido()->create([
                    'forma_pago_id' => $formaPago['id'],
                    'monto' => $formaPago['monto'],
                    'abreviatura' => $formaPago['abreviatura'],
                ]);
            }
            if ($req->entregado) {
                $pedido->items->each(function ($item) {

                    $stock = $item->producto->stock()->where('deposito_id', $item->deposito_id)->first();

                    if ($stock) {
                        $stock->decrement('cantidad', $item->cantidad);
                    } else {
                        throw new \Exception("No se encontró stock para el producto {$item->producto_id} en el depósito {$item->deposito_id}");
                    }
                });
            }
            DB::commit();
            $results = $pedido->load('items', 'cliente', 'formasPagoPedido', 'user');
            return response()->json(['success' => true, 'message' => 'Pedido creado con éxito', 'results' => $results], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al crear el pedido', 'error' => $e->getMessage()], 500);
        }
    }


    public function cambiarEstado($id, Request $req)
    {
        $validator = Validator::make($req->all(), [
            'estado' => 'required|in:1,2,3,4,5'
        ]);
        $estado = $req->estado;
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 400);
        }

        if ($estado == 1) {
            return response()->json(['success' => false, 'message' => 'No se puede cambiar el estado a pendiente'], 400);
        }



        $pedido = Pedido::find($id);
        if (!$pedido)
            return response()->json(['success' => false, 'message' => 'Pedido no encontrado'], 404);
        $pedido->estado = $estado;
        $pedido->save();
        $pedido->load('items');
        $message = 'Pedido procesado con éxito.';
        if ($estado == 2) {
            $message = 'Pedido ha sido pagado.';
        }
        if ($estado == 3 && $pedido->tipo == 1 && $pedido->estado > 2) {
            $pedido->items->each(function ($item) {
                $item->producto->stock->where('deposito_id', $item->deposito_id)->first()->update([
                    'cantidad' => $item->producto->stock->where('deposito_id', $item->deposito_id)->first()->cantidad - $item->cantidad
                ]);
            });
            $message = 'Pedido ha sido entregado.';
        }

        return response()->json(['success' => true, 'message' => $message, 'results' => $pedido]);
    }

    
}
