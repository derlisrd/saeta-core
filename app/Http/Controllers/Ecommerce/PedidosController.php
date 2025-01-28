<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Models\PedidoItems;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PedidosController extends Controller
{
    public function misPedidos(Request $req){
        
        $user = $req->user();
        $cliente = $user->cliente;

        $pedidos = Pedido::where('pedidos.cliente_id',$cliente->id)
        ->select('id','total','estado','created_at as fecha')
        ->get();

        return response()->json([
            'success' => true,
            'results' => $pedidos
        ]);
    }

    public function itemsDeMiPedido(Request $req, $id){

        if(!$id){
            return response()->json([
                'success' => false,
                'message' => 'El código del pedido es requerido'
            ],400);
        }

        $user = $req->user();
        $cliente = $user->cliente;

        // Buscar el pedido por su id
        $pedido = Pedido::findOrFail($id);

        // Verificar si el cliente_id del pedido coincide con el id del cliente del usuario autenticado
        if ($pedido->cliente_id !== $cliente->id) {
            return response()->json([
                'success' => false,
                'message' => 'No hay pedido'
            ], 400);
        }

        $items = PedidoItems::where('pedido_id',$id)
        ->join('productos as p','p.id','pedidos_items.producto_id')
        ->select('p.nombre','pedidos_items.precio','pedidos_items.cantidad','pedidos_items.total')
        ->get();

        return response()->json([
            'success' => true,
            'results' => $items
        ]);
    }


    public function crearPedido(Request $req)
    {
        // Validar los datos de entrada
        $validator = Validator::make($req->all(), [
            'formas_pago_id' => 'required|integer|exists:formas_pago,id',
            'aplicar_impuesto' => 'required|boolean',
            'tipo' => 'required|string',
            'porcentaje_descuento' => 'required|numeric|min:0',
            'descuento' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'entregado' => 'required|boolean',
            'items' => 'required|array|min:1',
            'items.*.producto_id' => 'required|integer|exists:productos,id',
            'items.*.impuesto_id' => 'required|integer|exists:impuestos,id',
            'items.*.deposito_id' => 'required|integer|exists:depositos,id',
            'items.*.cantidad' => 'required|numeric|min:1',
            'items.*.precio' => 'required|numeric|min:0',
            'items.*.descuento' => 'required|numeric|min:0',
            'items.*.total' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 400);
        }

        DB::beginTransaction();
        try {
            $user = auth()->user();
            $data = $req->all();

            $total = 0;
            $items = [];
            foreach ($data['items'] as $item) {
                $producto = Producto::findOrFail($item['producto_id']);
                $total += $producto->precio * $item['cantidad'];
                $items[] = [
                    'producto_id' => $producto->id,
                    'precio' => $producto->precio,
                    'cantidad' => $item['cantidad'],
                    'total' => $producto->precio * $item['cantidad']
                ];
            }

            $pedido = Pedido::create([
                'cliente_id' => $data['cliente_id'],
                'user_id' => $user->id,
                'formas_pago_id' => $data['formas_pago_id'],
                'aplicar_impuesto' => $data['aplicar_impuesto'],
                'tipo' => $data['tipo'],
                'porcentaje_descuento' => $data['porcentaje_descuento'],
                'descuento' => $data['descuento'],
                'total' => $total,
                'estado' => $data['entregado'] ? 3 : 1
            ]);

            
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
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Pedido registrado',
                'pedido' => $pedido
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error al crear el pedido', 'error' => $e->getMessage()], 500);
        }
    }
}
