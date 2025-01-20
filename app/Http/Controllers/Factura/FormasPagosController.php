<?php

namespace App\Http\Controllers\Factura;

use App\Http\Controllers\Controller;
use App\Models\FormasPago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FormasPagosController extends Controller
{
    public function index()
    {
        $results = FormasPago::all();
        return response()->json([
            'success' => true,
            'resutls' => $results
        ]);
    }

    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'tipo' => 'required|in:efectivo,digital',
            'descripcion' => 'required',
            'porcentaje_descuento'=>'nullable|numeric'
        ]);
        if ($validator->fails())
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 400);

        $formaPago = FormasPago::create([
            'tipo' => $req->tipo,
            'descripcion' => $req->descripcion,
            'porcentaje_descuento' => $req->porcentaje_descuento
        ]);

        return response()->json([
            'success' => true,
            'results' => $formaPago,
            'message' => 'Forma de pago creada correctamente'
        ]);
    }
}
