<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmpresaController extends Controller
{

    public function index()
    {
        $empresa = Empresa::find(1);
        return response()->json([
            'success' => true,
            'data' => $empresa
        ]);
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'ruc' => 'required',
            'telefono' => 'required',
            'direccion' => 'required|string',
            'propietario' => 'nullable|string'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message'=> $validator->errors()->first()
            ], 400);
        }
        $empresa = Empresa::find(1);
        $empresa->update($request->all());
        return response()->json([
            'success' => true,
            'message'=> 'Empresa actualizada correctamente'
        ]);
    }
}
