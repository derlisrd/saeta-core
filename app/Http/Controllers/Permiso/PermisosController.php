<?php

namespace App\Http\Controllers\Permiso;

use App\Http\Controllers\Controller;
use App\Models\Permiso;
use App\Models\PermisosOtorgado;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermisosController extends Controller
{
    public function index()
    {
        $permisos = Permiso::all();
        return response()->json([
            'success' => true,
            'results' => $permisos
        ]);        
    }

    public function permisosByUser(Request $req,$id){

        $permisosByUser = PermisosOtorgado::where('user_id', $id)->get();

        return response()->json([
            'success' => true,
            'results' => $permisosByUser
        ]);
    }

    public function administradores(){
        $admins = User::where('tipo',10)->get();
        return response()->json([
            'succcess' => true,
            'results' => $admins
        ]);
    }

    // Asignar permisos a un user
    public function asignar(Request $request)
    {
        $request->validate([
            'users_id' => 'required|exists:users,id',
            'permisos' => 'required|array',
            'permisos.*' => 'exists:permisos,id',
        ]);

        $user = User::findOrFail($request->admin_id);
        $user->permisos()->syncWithoutDetaching($request->permisos);

        return response()->json([
            'success' => true,
            'message' => 'Permisos asignados correctamente.']);
    }

    // Quitar permisos de un user
    public function revocar(Request $request)
    {
        $request->validate([
            'admin_id' => 'required|exists:admins,id',
            'permisos' => 'required|array',
            'permisos.*' => 'exists:permisos,id',
        ]);

        $user = User::findOrFail($request->admin_id);
        $user->permisos()->detach($request->permisos);

        return response()->json([
            'success' => true,
            'message' => 'Permisos revocados correctamente.']);
    }

}
