<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Models\Parametro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ParametrosController extends Controller
{

    public function index(){
        try{
            $parametros = Parametro::all();
            return response()->json(['success' => true, 'results' => $parametros]);
        }catch(\Exception $e){
            return response()->json(['success' => false, 'message' => 'Error al obtener los parámetros en servidor.'], 500);
        }
    }

    public function show(Request $request){
        try{
            $clave = $request->input('clave');
            $parametro = Parametro::where('clave', $clave)->first();
            return response()->json(['success' => true, 'results' => $parametro]);
        }catch(\Exception $e){
            return response()->json(['success' => false, 'message' => 'Error al obtener el parámetro en servidor.'], 500);
        }
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'clave' => 'required',
            'valor' => 'required',
        ]);

        if ($validator->fails()) 
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 400);
        
        try{
            Parametro::where('clave', $request->clave)->update(['valor' => $request->valor]);

            return response()->json(['success' => true, 'message' => 'Parámetro actualizado correctamente']);

        }catch(\Exception $e){
            return response()->json(['success' => false, 'message' => 'Error al actualizar el parámetro en servidor.'], 500);
        }
    }
}
