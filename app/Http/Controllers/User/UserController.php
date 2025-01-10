<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function me(Request $req){
        $user = $req->user();
        return response()->json([
            'success'=>true,
            'results'=>$user,
            'message'=>''
        ]);
    }

    public function recuperar(Request $req){
        try {
            $datos = [
                'email'=>$req->email,
                'asunto'=>'Recuperar contraseña'
            ];
            Mail::send('email.recuperar',['code'=>111111], function ($message) use($datos) {
                $message->subject($datos['asunto']);
                $message->to($datos['email']);
            });
            return response()->json(['success'=>true]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function create(Request $req){
        $user = $req->user();
        
        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'nombre' => 'required',
            'apellido' => 'required',
            'sucursal_id' => 'required|exists:sucursales,id'
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }
        $user = User::create([
            'name',
            'empresa_id'=>1,
            'sucursal_id'=>$req->sucursal_id,
            'username' => $req->username,
            'email' => $req->email,
            'password' => bcrypt($req->password),
            'tipo'=> 1,
            'activo'=>1,
            'cambiar_password'=>true
        ]);

        return response()->json([
            'success'=>true,
            'results'=>$user,
            'message'=>'Usuario creado'
        ]);
    }
}
