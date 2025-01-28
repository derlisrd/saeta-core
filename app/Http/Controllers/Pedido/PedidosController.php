<?php

namespace App\Http\Controllers\Pedido;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PedidosController extends Controller
{
    public function index(Request $req) {
        // Validar las fechas de entrada
        $validator = Validator::make($req->all(), [
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 400);
        }

        // Utilizar Carbon para manejar las fechas
        $today = Carbon::today();
        $start = $req->start_date ? Carbon::parse($req->start_date)->startOfDay() : $today->startOfDay();
        $end = $req->end_date ? Carbon::parse($req->end_date)->endOfDay() : $today->endOfDay();

        // Obtener los pedidos en el rango de fechas
        $pedidos = Pedido::whereBetween('created_at', [$start, $end])->get();

        if ($pedidos->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No se encontraron pedidos en el rango de fechas especificado'], 404);
        }

        return response()->json(['success' => true, 'results' => $pedidos]);
    }

    public function find($id) {
        $pedido = Pedido::with('items')->find($id);
        if (!$pedido)
            return response()->json(['success' => false, 'message' => 'Pedido no encontrado'], 404);
        return response()->json(['success' => true, 'results' => $pedido], 200);
    }

    public function store(Request $req)
    {
        // Validar los datos de entrada
        $validatorPedido = Validator::make($req->all(), [
            'cliente_id' => 'required|integer|exists:clientes,id',
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

        if ($validatorPedido->fails()) {
            return response()->json(['success' => false, 'message' => $validatorPedido->errors()->first()], 400);
        }

        DB::beginTransaction();
        try {
            $user = auth()->user();
            $datas = [
                'user_id' => $user->id,
                'cliente_id' => $req->cliente_id === 0 ? 1 : $req->cliente_id,
                'formas_pago_id' => $req->formas_pago_id,
                'aplicar_impuesto' => $req->aplicar_impuesto,
                'tipo' => $req->tipo,
                'porcentaje_descuento' => $req->porcentaje_descuento,
                'descuento' => $req->descuento,
                'total' => $req->total,
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

            DB::commit();
            return response()->json(['success' => true, 'results' => $pedido], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error al crear el pedido', 'error' => $e->getMessage()], 500);
        }
    }


    public function cambiarEstado($id, Request $req) {
        $validator = Validator::make($req->all(), [
            'estado' => 'required|in:1,2,3,4,5'
        ]);
        $estado = $req->estado;
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 400);
        }

        if($estado == 1){
            return response()->json(['success' => false, 'message' => 'No se puede cambiar el estado a pendiente'], 400);
        }

        

        $pedido = Pedido::find($id);
        if (!$pedido)
            return response()->json(['success' => false, 'message' => 'Pedido no encontrado'], 404);
        $pedido->estado = $estado;
        $pedido->save();
        $pedido->load('items');
        $message = 'Pedido procesado con éxito.';
        if($estado == 2){
            $message = 'Pedido ha sido pagado.';
        }
        if($estado == 3 && $pedido->tipo == 1 && $pedido->estado > 2){
         $pedido->items->each(function($item){
            $item->producto->stock->where('deposito_id',$item->deposito_id)->first()->update([
                'cantidad'=>$item->producto->stock->where('deposito_id',$item->deposito_id)->first()->cantidad - $item->cantidad
            ]);
         });
         $message = 'Pedido ha sido entregado.';   
        }

        return response()->json(['success' => true, 'message' => $message, 'results' => $pedido]);
    }

}
