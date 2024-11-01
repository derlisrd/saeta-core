<?php

namespace App\Http\Controllers\Producto;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductosController extends Controller
{
    public function index(Request $request){
        try {

            $count = Producto::count();
            $limit = $request->query('limit', 120); 
            $page = $request->query('page', 1); 
            $offset = ($page - 1) * $limit; 

            $results = Producto::orderBy('nombre', 'asc')
            ->where('like','%'.$request->q.'%')
            ->offset($offset)
            ->limit($limit)
            ->get();

            return response()->json([
                'success'=>true,
                'total'=>$count,
                'results'=>$results
            ]);
        } catch (\Throwable $th) {
            throw $th;
            return response()->json([
                'success'=>false,
                'message'=> 'Error de servidor. SEQ29'
            ],500);
        }
    }

    public function find($id){
        $results = Producto::find($id);
        if(!$results){
            return response()->json([
                'success'=>false,
                'results'=>null,
                'message'=>'Producto no existe'
            ],404);
        }
        return response()->json([
            'success'=>true,
            'results'=>$results,
            'message'=>''
        ]);
    }

    public function store(Request $req){
        $validator = Validator::make($req->all(),[
            'impuesto_id'=>'required',
            'codigo'=>'required|unique:productos,codigo',
            'nombre'=>'required'
        ]);
        if($validator->fails())
            return response()->json(['success'=>false,'message'=>$validator->errors()->first() ], 400);

        $user = $req->user();
        $datos = [
            'category_id' =>$req->category_id,
            'medida_id' =>$req->medida_id,
            'impuesto_id'=> $req->impuesto_id,
            'creado_por' =>$user->id,
            'modificado_por' =>$user->id,
            'codigo' =>$req->codigo,
            'nombre' =>$req->nombre,
            'descripcion'=>$req->descripcion,
            'costo' =>$req->costo,
            'modo_comision' => $req->modo_comision,
            'porcentaje_comision' => $req->porcentaje_comision,
            'valor_comision' => $req->valor_comision,
            'precio_normal' => $req->precio_normal,
            'precio_descuento' =>$req->precio_descuento,
            'precio_minimo' =>$req->precio_minimo,
            'porcentaje_impuesto' => $req->porcentaje_impuesto,
            'disponible' =>$req->disponible,
            'tipo' =>$req->tipo,
            'preguntar_precio' => $req->preguntar_precio,
            'notificar_minimo' =>$req->notificar_minimo,
            'cantidad_minima' =>$req->cantidad_minima
        ];

        $store = Producto::create($datos);

        return response()->json([
            'success'=>true,
            'message'=>'Producto creado',
            'results' =>$store
        ]);
    }

    public function update(Request $req, $id){
        $user = $req->user();
        $datos = [
            'category_id' =>$req->category_id,
            'medida_id' =>$req->medida_id,
            'impuesto_id'=> $req->impuesto_id,
            'modificado_por' =>$user->id,
            'codigo' =>$req->codigo,
            'nombre' =>$req->nombre,
            'descripcion'=>$req->descripcion,
            'costo' =>$req->costo,
            'modo_comision' => $req->modo_comision,
            'porcentaje_comision' => $req->porcentaje_comision,
            'valor_comision' => $req->valor_comision,
            'precio_normal' => $req->precio_normal,
            'precio_descuento' =>$req->precio_descuento,
            'precio_minimo' =>$req->precio_minimo,
            'porcentaje_impuesto' => $req->porcentaje_impuesto,
            'disponible' =>$req->disponible,
            'tipo' =>$req->tipo,
            'preguntar_precio' => $req->preguntar_precio,
            'notificar_minimo' =>$req->notificar_minimo,
            'cantidad_minima' =>$req->cantidad_minima
        ];

        $producto = Producto::find($id);
        if (!$producto) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado',
                'results' => null
            ], 404);
        }
        $producto->update($datos);
        return response()->json([
            'success'=>true,
            'message'=>'Producto modificado',
            'results' =>$producto
        ]);
    }

    public function destroy($id){
        try {
           $producto = Producto::find($id);
           $producto->destroy();

           return response()->json([
            'success'=>true,
            'message'=>'Producto eliminado'
        ]);
        } catch (\Throwable $th) {
            throw $th;
            return response()->json([
                'success'=>false,
                'message'=> 'Error de servidor. SEQ132'
            ],500);
        }
    }
}
