<?php

namespace App\Http\Controllers\Producto;

use App\Http\Controllers\Controller;
use App\Models\Medida;
use Illuminate\Http\Request;

class MedidasController extends Controller
{
    public function index(){
        $medidas = Medida::all();
        return response()->json([
            'success'=>true,
            'results'=>$medidas
        ]);
    }
}
