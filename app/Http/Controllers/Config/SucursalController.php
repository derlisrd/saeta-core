<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Models\Sucursal;
use Illuminate\Http\Request;

class SucursalController extends Controller
{
    public function index(){
        return response()->json([
            'success' => true,
            'data' => Sucursal::all()
        ]);
    }
}
