<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Models\Impresora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImpresorasController extends Controller
{
    public function index(Request $req)
    {
        $user = $req->user();
        $sucursal_id = $user->sucursal_id;
        $impresoras = Impresora::where('sucursal_id', $sucursal_id)->get();
        return response()->json([
            'success' => true,
            'results' => $impresoras
        ]);
    }

    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'sucursal_id' => 'required',
            'nombre' => 'required',
            'mm' => 'required|numeric',
            'activo' => 'required|boolean'
        ]);

        if ($validator->fails())
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);

        $impresora = Impresora::create([
            'sucursal_id' => $req->sucursal_id,
            'nombre' => $req->nombre,
            'mm' => $req->mm,
            'activo' => $req->activo ?? false
        ]);

        return response()->json([
            'success' => true,
            'results' => $impresora
        ]);
    }

    public function update(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'nombre' => 'required',
            'modelo' => 'nullable',
            'mm' => 'required|numeric',
            'activo' => 'required|boolean'
        ]);

        if ($validator->fails())
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);

        Impresora::where('id', $id)->update([
            'nombre' => $req->nombre,
            'modelo' => $req->modelo,
            'mm' => $req->mm,
            'activo' => $req->activo
        ]);
        return response()->json([
            'success' => true,
            'results' => Impresora::find($id)
        ]);
    }
}
