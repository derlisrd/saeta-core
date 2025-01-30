<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
    public function store(Request $req){
        // Validar los datos de entrada
        $validator = Validator::make($req->all(), [
            'nombres' => 'required|string',
            'apellidos' => 'required|string',
            'razonSocial' => 'nullable|string',
            'doc' => 'required|string|unique:clientes,doc',
            'direccion' => 'nullable|string',
            'telefono' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'results' => null,
                'message' => $validator->errors()->first()
            ], 400);
        }

        $user = $req->user();
        $razonSocial = $req->razonSocial ? $req->razonSocial :  $req->nombres . ' ' . $req->apellidos;
        
        $cliente = Cliente::create([
            'doc' => $req->doc,
            'nombres' => $req->nombres,
            'apellidos' => $req->apellidos,
            'razon_social' => $razonSocial,
            'direccion' => $req->direccion,
            'telefono' => $req->telefono,
            'email' => $req->email,
            'nacimiento' => $req->nacimiento,
        ]);

        $user->cliente_id = $cliente->id;
        $user->save();

    }
}
