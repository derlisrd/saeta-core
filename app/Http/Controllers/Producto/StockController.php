<?php

namespace App\Http\Controllers\Producto;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
    public function add(Request $req){

        $validator = Validator::make($req->all(),[
            'producto_id'=>'required|exists:productos,id',
            'deposito_id'=>'required|exists:depositos,id',
            'medida_id'=>'required|exists:medidas,id',
            'cantidad'=>'required|numeric|min:1'
        ]);

        if($validator->fails()){
            return response()->json([
                'success'=>false,
                'message'=>$validator->errors()->first()
            ],400);
        }

        Stock::create([
            'producto_id'=>$req->producto_id,
            'deposito_id'=>$req->deposito_id,
            'medida_id'=>$req->medida_id,
            'cantidad'=>$req->cantidad
        ]);

        return response()->json([
            'success'=>true,
            'message'=>'Stock agregado'
        ]);
    }
}
