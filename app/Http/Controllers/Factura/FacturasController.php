<?php

namespace App\Http\Controllers\Factura;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FacturasController extends Controller
{
    public function index(Request $request){

    }

    public function store(Request $req){
       $validator = Validator::make($req->all(),[]);
       if($validator->fails())
            return response()->json(['success'=>false,'message'=>$validator->errors()->first() ], 400);
        
        
    }
}
