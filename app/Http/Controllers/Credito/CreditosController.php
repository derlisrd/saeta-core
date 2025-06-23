<?php

namespace App\Http\Controllers\Credito;

use App\Http\Controllers\Controller;
use App\Models\Credito;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CreditosController extends Controller
{

    public function index(Request $req){
        $validator = Validator::make($req->all(), [
            'desde' => 'nullable|date_format:Y-m-d',
            'hasta' => 'nullable|date_format:Y-m-d'
        ]);
        if ($validator->fails())
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 400);

            $desde = $req->desde ? Carbon::parse($req->desde) : Carbon::now();
            $hasta = $req->hasta ? Carbon::parse($req->hasta) : Carbon::now();
    
        $creditos = Credito::whereBetween('pedidos.created_at', [$desde->startOfDay(), $hasta->endOfDay()])
        ->join('pedidos as p', 'p.id', '=', 'creditos.pedido_id')
        ->join('clientes as cl', 'cl.id', '=', 'creditos.cliente_id')
        ->select('creditos.id','creditos.pedido_id','cl.razon_social','cl.doc','creditos.monto','creditos.fecha_vencimiento','creditos.created_at')
        ->get();
        
        return response()->json(['success' => true, 'results'=>$creditos]);
    }

    public function aCobrar(Request $req){
        $creditos = Credito::where('pagado', 0)
        ->join('pedidos as p', 'p.id', '=', 'creditos.pedido_id')
        ->join('clientes as cl', 'cl.id', '=', 'creditos.cliente_id')
        ->select('creditos.id','creditos.pedido_id','cl.razon_social','cl.doc','creditos.monto','creditos.fecha_vencimiento','creditos.created_at')
        ->get();

        return response()->json(['success' => true, 'results' => $creditos]);
    }
}
