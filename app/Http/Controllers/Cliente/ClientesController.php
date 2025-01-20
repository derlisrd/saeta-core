<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientesController extends Controller
{

    public function search($q){
        
        if($q == ''){
            return response()->json([
                'success' => false,
                'results' => [],
                'message' => 'Debe ingresar un valor a buscar'
            ], 400);
        }

        $clientes = Cliente::where('doc', 'like', '%'.$q.'%')
            ->orWhere('nombres', 'like', '%'.$q.'%')
            ->orWhere('apellidos', 'like', '%'.$q.'%')
            ->get();
        return response()->json([
            'success' => true,
            'results' => $clientes,
            'message' => ''
        ]);
    }

    public function show($id){
        $cliente = Cliente::find($id);
        if(!$cliente){
            return response()->json([
                'success' => false,
                'results' => null,
                'message' => 'Cliente no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'results' => $cliente
        ]);
    }

    public function index(){
        $clientes = Cliente::all();
        return response()->json([
            'success' => true,
            'results' => $clientes
        ]);
    }

    public function update($id, Request $req){
        $cliente = Cliente::find($id);
        if(!$cliente){
            return response()->json([
                'success' => false,
                'results' => null,
                'message' => 'Cliente no encontrado'
            ], 404);
        }
        $validator = Validator::make($req->all(),[
            'doc' => 'required|unique:clientes,doc,'.$id,
            'nombres' => 'required',
            'apellidos' => 'nullable',
            'nombre_fantasia' => 'nullable',
            'direccion' => 'nullable',
            'telefono' => 'nullable',
            'email' => 'nullable|email',
            'nacimiento' => 'nullable|date',
            'tipo' => 'in:0,1',
            'extranjero' => 'in:0,1'
        ]);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        $cliente->update([
            'doc' => $req->doc,
            'nombres' => $req->nombres,
            'apellidos' => $req->apellidos,
            'nombre_fantasia' => $req->nombre_fantasia,
            'direccion' => $req->direccion,
            'telefono' => $req->telefono,
            'email' => $req->email,
            'nacimiento' => $req->nacimiento,
            'tipo' => $req->tipo,
            'extranjero' => $req->extranjero
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Cliente actualizado correctamente',
            'results' => $cliente
        ]);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'doc' => 'required|unique:clientes',
            'nombres' => 'required',
            'apellidos' => 'nullable',
            'nombre_fantasia' => 'nullable',
            'direccion' => 'nullable',
            'telefono' => 'nullable',
            'email' => 'nullable|email',
            'nacimiento' => 'nullable|date',
            'tipo' => 'in:0,1',
            'extranjero' => 'in:0,1'
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        $cliente = Cliente::create([
            'doc' => $request->doc,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'nombre_fantasia' => $request->nombre_fantasia,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'nacimiento' => $request->nacimiento,
            'tipo' => $request->tipo,
            'extranjero' => $request->extranjero
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Cliente creado correctamente',
            'results' => $cliente
        ]);
    }

    
}
