<?php

namespace App\Http\Controllers\Factura;

use App\Http\Controllers\Controller;
use App\Models\Impuesto;
use Illuminate\Http\Request;

class ImpuestosController extends Controller
{
    public function index(){
        $impuestos = Impuesto::all();
        return response()->json([
            'success' => true,
            'results' => $impuestos
        ]);
    }
}
