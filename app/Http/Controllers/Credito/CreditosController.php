<?php

namespace App\Http\Controllers\Credito;

use App\Http\Controllers\Controller;
use App\Models\Cobro;
use App\Models\Credito;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CreditosController extends Controller
{
    public function find($id){
        $credito = Credito::where('creditos.id',$id)
            ->join('pedidos as p', 'p.id', '=', 'creditos.pedido_id')
            ->join('clientes as cl', 'cl.id', '=', 'creditos.cliente_id')
            ->with('cobros')
            ->select('creditos.id','creditos.pedido_id','cl.razon_social','cl.doc','creditos.monto','creditos.fecha_vencimiento',
            'creditos.created_at','p.importe_final','creditos.monto_abonado')
            ->first();
        
        return response()->json(['success' => true, 'results' => $credito]);
    }

    public function index(Request $req){
        $validator = Validator::make($req->all(), [
            'desde' => 'nullable|date_format:Y-m-d',
            'hasta' => 'nullable|date_format:Y-m-d'
        ]);
        if ($validator->fails())
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 400);

            $desde = $req->desde ? Carbon::parse($req->desde) : Carbon::now()->startOfMonth();
            $hasta = $req->hasta ? Carbon::parse($req->hasta) : Carbon::now();
    
        $creditos = Credito::whereBetween('creditos.created_at', [$desde->startOfDay(), $hasta->endOfDay()])
        ->join('pedidos as p', 'p.id', '=', 'creditos.pedido_id')
        ->join('clientes as cl', 'cl.id', '=', 'creditos.cliente_id')
            ->with('cobros')
        ->select('creditos.id','creditos.pedido_id','cl.razon_social','cl.doc','creditos.monto','creditos.fecha_vencimiento',
                'creditos.created_at','p.importe_final','creditos.pagado','creditos.monto_abonado')
        ->orderBy('creditos.created_at', 'asc')
        ->get();
        
        return response()->json(['success' => true, 'results'=>$creditos]);
    }

    public function aCobrar(){
        $creditos = Credito::where('pagado', 0)
        ->join('pedidos as p', 'p.id', '=', 'creditos.pedido_id')
        ->join('clientes as cl', 'cl.id', '=', 'creditos.cliente_id')
        ->select('creditos.id','creditos.pedido_id','cl.razon_social','cl.doc','creditos.monto','creditos.fecha_vencimiento',
                'creditos.created_at',
                'creditos.monto_abonado',
                'creditos.pagado'
            )
        ->get();

        return response()->json(['success' => true, 'results' => $creditos]);
    }

    public function cobrar(Request $req,$id){
        $validator = Validator::make($req->all(), [
            'forma_pago_id' => 'required|exists:formas_pagos,id',
            'monto' => 'required|numeric|min:0',
        ]);
        if ($validator->fails())
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 400);

        $credito = Credito::find($id);
        if ($credito->pagado === 1)
            return response()->json(['success' => false, 'message' => 'El credito ya fue pagado'], 400);
        
        $totalPagado = Cobro::where('credito_id', $credito->id)->sum('monto');
        // Verificar que el nuevo pago no exceda la deuda pendiente
        $deudaPendiente = $credito->monto - $totalPagado;

        if ($req->monto > $deudaPendiente) 
            return response()->json([
                'success' => false, 
                'message' => "El monto excede la deuda pendiente. Deuda pendiente: $deudaPendiente"
            ], 400);
        
            Cobro::create([
                'user_id' => $req->user()->id,
                'pedido_id' => $credito->pedido_id,
                'credito_id' => $credito->id,
                'cliente_id' => $credito->cliente_id,
                'forma_pago_id' => $req->forma_pago_id,
                'monto' => $req->monto,
            ]);
            $totalPagadoActualizado = $totalPagado + $req->monto;
            
            $updateArray = [
            'pagado' => $totalPagadoActualizado >= $credito->monto ? 1 : 0,
            'monto_abonado' => $totalPagadoActualizado,
            ];
            
            $credito->update($updateArray);
            
            return response()->json([
                'success' => true, 
                'message' => 'Cobro registrado exitosamente',
                'results'=>[
                    'credito_pagado' => $credito->pagado === 1,
                    'deuda_restante' => max(0, $credito->monto - $totalPagadoActualizado)
                ]
            ]);
    }
}
