<?php

namespace App\Http\Controllers\Producto;

use App\Http\Controllers\Controller;
use App\Models\Medida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MedidasController extends Controller
{
    public function index(){
        $medidas = Medida::all();
        return response()->json([
            'success'=>true,
            'results'=>$medidas
        ]);
    }
    public function store(Request $req){
        $validator = Validator::make($req->all(),[
            'descripcion'=>'required',
            'abreviatura'=>'required'
        ]);
        if($validator->fails()){
            return response()->json([
                'success'=>false,
                'message'=>$validator->errors()->first()
            ],400);
        }
        $medida = Medida::create([
            'descripcion'=>$req->descripcion,
        'abreviatura'=>$req->abreviatura
        ]);
        return response()->json([
            'success'=>true,
            'message'=>'Medida creada',
            'results'=>$medida
        ]);
    }
}
