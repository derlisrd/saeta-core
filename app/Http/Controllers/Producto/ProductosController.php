<?php

namespace App\Http\Controllers\Producto;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    public function index(){
        return response()->json([
            'success'=>true,
            'results'=>Producto::all()
        ]);
    }
}
