<?php

namespace App\Http\Controllers\Producto;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    public function index(Request $request){
        
        
        
        
        
        $count = Producto::count();
        $result = Producto::limite(120)->sortBy(['id','desc']) ->get();

        return response()->json([
            'success'=>true,
            'total'=>$count,
            'results'=>$result
        ]);
    }
}
