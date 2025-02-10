<?php

namespace App\Http\Controllers\Producto;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
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

    public function corregir(Request $req){
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
        

        // Crear o actualizar el stock
        $stock = Stock::updateOrCreate(
            [
                'producto_id' => $req->producto_id,
                'deposito_id' => $req->deposito_id,
                'medida_id' => $req->medida_id
            ],
            [
                'cantidad' => $req->cantidad // Sumar la cantidad si ya existe
            ]
        );

        return response()->json([
            'success' => true,
            'results' => $stock,
            'message' => 'Stock actualizado correctamente']);

    }
    
}
