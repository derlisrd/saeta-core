<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;


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
}
