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

    public function index(Request $req){
        $users = User::where('hidden', 0)->get();
        return response()->json([
            'success'=>true,
            'results'=>$users,
            'message'=>''
        ]);
    }   




    public function create(Request $req){
        
        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'sucursal_id' => 'required|exists:sucursales,id'
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }
        $user = User::create([
            'name'=>$req->name,
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

    public function resetPassword(Request $req){
        $validator = Validator::make($req->all(), [
            'id' => 'required|exists:users,id',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        User::where('id', $req->id)->update([
            'password' => bcrypt($req->password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cambio de contraseña realizado correctamente'
        ]);
    }
}
