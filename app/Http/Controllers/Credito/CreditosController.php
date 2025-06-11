<?php

namespace App\Http\Controllers\Credito;

use App\Http\Controllers\Controller;
use App\Models\Credito;
use Illuminate\Http\Request;

class CreditosController extends Controller
{

    public function index(){
        $creditos = Credito::all();
        return response()->json(['success' => true, 'results'=>$creditos]);
    }
}
