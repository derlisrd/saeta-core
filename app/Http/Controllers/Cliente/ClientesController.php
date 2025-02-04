<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Services\RucParaguayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ClientesController extends Controller
{

    public function porDocumento($doc){
        $cliente = Cliente::where('doc',$doc)->first();
        
        if(!$cliente){
            $rucService = new RucParaguayService();
            $info = $rucService->infoRuc2($doc);
            
            if($info){
                $cliente = [
                    'doc' => $info['ruc'],
                    'nombres' => $info['nombre'],
                    'razon_social' => $info['nombre'],
                    'tipo' => 1,
                    'juridica' => $info['juridico']
                ];
            } 
            return response()->json([
                'success' => false,
                'results' => $info,
            ]);
        }

        return response()->json([
            'success' => true,
            'results' => $cliente
        ]);
    }

    public function search(Request $req){

        $q = $req->q;
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
            ->orWhere('razon_social', 'like', '%'.$q.'%')
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
            'razon_social' => 'nullable',
            'direccion' => 'nullable',
            'telefono' => 'nullable',
            'email' => 'nullable|email',
            'nacimiento' => 'nullable|date',
            'juridica' => 'boolean',
            'tipo' => 'in:0,1',
            'extranjero' => 'in:0,1'
        ]);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }
        $razon_social = $req->razon_social;
        if($razon_social == '' || $razon_social == null){
            $razon_social = $req->nombre . ' ' . $req->apellidos;
        }

        $cliente->update([
            'doc' => $req->doc,
            'nombres' => $req->nombres,
            'apellidos' => $req->apellidos,
            'razon_social' => $razon_social,
            'direccion' => $req->direccion,
            'telefono' => $req->telefono,
            'email' => $req->email,
            'nacimiento' => $req->nacimiento,
            'tipo' => $req->tipo,
            'juridica' => $req->juridica,
            'extranjero' => $req->extranjero,
            'web'=>$req->web
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Cliente actualizado correctamente',
            'results' => $cliente
        ]);
    }

    public function store(Request $req){
        $validator = Validator::make($req->all(),[
            'doc' => 'required|unique:clientes',
            'nombres' => 'required',
            'apellidos' => 'nullable',
            'razon_social' => 'nullable',
            'direccion' => 'nullable',
            'telefono' => 'nullable',
            'email' => 'nullable|email',
            'nacimiento' => 'nullable|date',
            'tipo' => 'required|in:0,1',
            'extranjero' => 'in:0,1'
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        $razon_social = $req->razon_social;
        if($razon_social == '' || $razon_social == null){
            $razon_social = $req->nombre . ' ' . $req->apellidos;
        }


        $cliente = Cliente::create([
            'doc' => $req->doc,
            'nombres' => $req->nombres,
            'apellidos' => $req->apellidos,
            'razon_social' => $razon_social,
            'direccion' => $req->direccion,
            'telefono' => $req->telefono,
            'email' => $req->email,
            'nacimiento' => $req->nacimiento,
            'tipo' => $req->tipo,
            'extranjero' => $req->extranjero
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Cliente creado correctamente',
            'results' => $cliente
        ]);
    }

    
}
