<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Models\PedidoItems;
use Illuminate\Http\Request;

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
        Pedido::where('cliente_id',$req->user()->cliente->id)->findOrFail($id);

        $items = PedidoItems::where('pedido_id',$id)
        ->join('productos as p','p.id','pedidos_items.producto_id')
        ->select('p.nombre','pedidos_items.precio','pedidos_items.cantidad','pedidos_items.total')
        ->get();

        return response()->json([
            'success' => true,
            'results' => $items
        ]);
    }
}
