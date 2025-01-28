<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function update(Request $req){
        $user = $req->user();
        $cliente = $user->cliente;

        $cliente->update($req->all());

        return response()->json([
            'success' => true,
            'results' => $cliente
        ]);
    }

    public function me(Request $req){
        $user = auth('api')->user();

        $userData = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'username' => $user->username,
            'cliente_id' => $user->cliente_id
        ];

        return response()->json([
            'success' => true,
            'results' => $userData,
            'message' => 'User data'
        ]);

    }
}
