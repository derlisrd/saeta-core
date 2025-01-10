<?php

namespace App\Http\Controllers\Permiso;

use App\Http\Controllers\Controller;
use App\Models\PermisosOtorgado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermisosController extends Controller
{
    public function otorgarPermisos(Request $req){
        $validator = Validator::make($req->all(), [
            'user_id' => 'required|exists:users,id',
            'permiso_id' => 'required|exists:permisos,id',
            'otorgado' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        PermisosOtorgado::updateOrCreate(
            ['user_id' => $req->user_id, 'permiso_id' => $req->permiso_id],
            ['otorgado' => $req->otorgado]
        );
        return response()->json([
            'success' => true,
            'message' => 'Permiso modificado correctamente'
        ]);
    }
}
