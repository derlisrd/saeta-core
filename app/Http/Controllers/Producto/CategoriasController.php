<?php

namespace App\Http\Controllers\Producto;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriasController extends Controller
{
    public function index(){
        $categorias = Category::all();
        return response()->json([
            'success' => true,
            'results' => $categorias
        ]);
    }

    public function store(Request $request){
        
        $validator = Validator::make($request->all(),[
            'nombre'=>'required',
            'descripcion'=>'nullable',
            'publicado'=>'boolean'
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ],400);
        }

        $categoria = Category::create([
            'nombre'=>$request->nombre,
            'descripcion'=>$request->descripcion,
            'publicado'=>true
        ]);
        return response()->json([
            'success' => true,
            'results' => $categoria
        ]);
    }

    public function update(Request $request,$id){
        $categoria = Category::find($id);
        if(!$categoria){
            return response()->json([
                'success' => false,
                'message' => 'Categoria no encontrada'
            ],404);
        }

        $validator = Validator::make($request->all(),[
            'nombre'=>'required',
            'descripcion'=>'nullable',
            'publicado'=>'boolean'
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ],400);
        }

        $categoria->update([
            'nombre'=>$request->nombre,
            'descripcion'=>$request->descripcion,
            'publicado'=>$request->publicado
        ]);

        return response()->json([
            'success' => true,
            'results' => $categoria
        ]);
    }

    public function destroy($id){
        $categoria = Category::find($id);
        if(!$categoria){
            return response()->json([
                'success' => false,
                'message' => 'Categoria no encontrada'
            ],404);
        }

        $categoria->delete();
        return response()->json([
            'success' => true,
            'message' => 'Categoria eliminada'
        ]);
    }
}
