<?php

namespace App\Http\Controllers\Producto;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{

    public function consultarStock(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'producto_id' => 'required|exists:productos,id',
            'deposito_id' => 'required|exists:depositos,id',
        ]);

        if ($validator->fails())
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);


        $stock = Stock::where('producto_id', $req->producto_id)
            ->where('deposito_id', $req->deposito_id)
            ->first();

        if (!$stock) {
            return response()->json([
                'success' => true,
                'message' => 'Producto existente pero sin stock',
                'results' => null
            ]);
        }

        return response()->json([
            'success' => true,
            'results' => $stock,
            'message' => 'Stock consultado correctamente'
        ]);
    }

    public function add(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'producto_id' => 'required|exists:productos,id',
            'deposito_id' => 'required|exists:depositos,id',
            'medida_id' => 'required|exists:medidas,id',
            'cantidad' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        // Crear o actualizar el stock
        $stock = Stock::updateOrCreate(
            [
                'producto_id' => $req->producto_id,
                'deposito_id' => $req->deposito_id,
                'medida_id' => $req->medida_id
            ],
            [
                'cantidad' => DB::raw("cantidad + {$req->cantidad}") // Sumar la cantidad si ya existe
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Stock actualizado correctamente',
            'data' => $stock
        ]);
    }

    public function corregir(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'producto_id' => 'required|exists:productos,id',
            'deposito_id' => 'required|exists:depositos,id',
            'cantidad' => 'required|numeric'
        ]);

        if ($validator->fails())
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);

        $stockConsulta = Stock::where('producto_id', $req->producto_id)
            ->where('deposito_id', $req->deposito_id)
            ->select('cantidad')
            ->first();
        $cantidadActual  = $stockConsulta->cantidad ?? 0;
        Activity::create([
            'user_id' => $req->user()->id,
            'action' => 'stock',
            'description' => 'Corregir stock',
            'details' => 'Cantidad: '.$cantidadActual . ' De producto: ' . $req->producto_id . ' en depósito ' . $req->deposito_id . ' por cantidad: ' . $req->cantidad,
            'browser' => $req->header('User-Agent'),
        ]);

        // Crear o actualizar el stock
        $stockConsulta->updateOrCreate(
            [
                'producto_id' => $req->producto_id,
                'deposito_id' => $req->deposito_id,
            ],
            [
                'cantidad' => $req->cantidad // Sumar la cantidad si ya existe
            ]
        );

        return response()->json([
            'success' => true,
            'results' => [
                'producto_id' => $req->producto_id,
                'deposito_id' => $req->deposito_id,
                'cantidad' => $req->cantidad
            ],
            'message' => 'Stock actualizado correctamente'
        ]);
    }
}
