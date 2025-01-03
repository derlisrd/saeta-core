<?php

namespace App\Http\Controllers\Pedido;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PedidosController extends Controller
{
    public function index(Request $req) {
        // $pedidos = Pedido::with('items')->get();
        $today = date('Y-m-d');
        $inicialHour = '00:00:00';
        $finalHour = '23:59:59';
        $start = $req->start_date ? $req->start_date : $today;
        $end = $req->end_date ? $req->end_date : $today;
        $start_date = Carbon::parse($start . ' ' . $inicialHour);
        $end_date = Carbon::parse($end . ' ' . $finalHour);

        $pedidos = Pedido::whereBetween('created_at', [$start_date, $end_date])->get();
        return response()->json(['success' => true, 'results' => $pedidos], 200);
    }

    public function find($id) {
        $pedido = Pedido::with('items')->find($id);
        if (!$pedido)
            return response()->json(['success' => false, 'message' => 'Pedido no encontrado'], 404);
        return response()->json(['success' => true, 'results' => $pedido], 200);
    }

    public function store(Request $req)
    {
        $user = $req->user();
        $validatorPedido = Validator::make($req->all(), [
            'cliente_id' => 'required|exists:clientes,id',
            'formas_pago_id' => 'required|exists:formas_pagos,id',
            'aplicar_impuesto' => 'required|boolean',
            'tipo' => 'required',
            'porcentaje_descuento' => 'required|numeric|min:0',
            'descuento' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'items'=>'required|array',
            'items.*.producto_id' => 'required|exists:productos,id',
            'items.*.impuesto_id' => 'required|exists:impuestos,id',
            'items.*.deposito_id' => 'required|exists:depositos,id',
            'items.*.cantidad' => 'required|numeric|min:1',
            'items.*.precio' => 'required|numeric|min:0',
            'items.*.descuento' => 'required|numeric|min:0',
            'items.*.total' => 'required|numeric|min:0',
        ]);
        if ($validatorPedido->fails()) {
            return response()->json(['success' => false, 'message' => $validatorPedido->errors()->first()], 400);
        }
        

        $datas = [
            'user_id' => $user->id,
            'cliente_id' => $req->cliente_id,
            'formas_pago_id' => $req->formas_pago_id,
            'aplicar_impuesto' => $req->aplicar_impuesto,
            'tipo' => $req->tipo,
            'porcentaje_descuento' => $req->porcentaje_descuento,
            'descuento' => $req->descuento,
            'total' => $req->total,
            'estado'=>1
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
        return response()->json(['success' => true, 'message' => 'Pedido creado con éxito', 'results' => $pedido->load('items')], 201);
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
