<?php

namespace App\Http\Controllers\Producto;

use App\Http\Controllers\Controller;
use App\Models\Deposito;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DepositosController extends Controller
{
    public function index()
    {
        $depositos = Deposito::all();
        return response()->json([
            'success' => true,
            'results' => $depositos
        ]);
    }
    public function productosPorDeposito(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'deposito_id' => 'required|exists:depositos,id'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }
        $deposito_id = $req->query('deposito_id');
        $productos = Producto::join('stocks as s', 's.producto_id', 'productos.id')
            ->join('depositos as d', 'd.id', 's.deposito_id')
            ->where('s.deposito_id', $deposito_id)
            ->select('productos.id', 'productos.nombre', 'productos.descripcion', 's.cantidad', 'd.nombre as deposito', 'd.id as deposito_id')
            ->get();
        return response()->json([
            'success' => true,
            'results' => $productos
        ]);
    }

    public function addDeposito(Request $req)
    {

        $deposito = Deposito::create([
            'sucursal_id' => $req->sucursal_id,
            'nombre' => $req->nombre,
            'descripcion' => $req->descripcion
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Deposito creado',
            'results' => $deposito
        ]);
    }

    public function update($id, Request $req)
    {
        $validator = Validator::make($req->all(), [
            // 'sucursal_id' => 'required|exists:sucursales,id',
            'nombre' => 'required',
            'descripcion' => 'nullable'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }
        $deposito = Deposito::find($id);
        if (!$deposito) {
            return response()->json([
                'success' => false,
                'message' => 'Deposito no encontrado'
            ], 404);
        }
        $deposito->update([
            // 'sucursal_id' => $req->sucursal_id,
            'nombre' => $req->nombre,
            'descripcion' => $req->descripcion
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Deposito actualizado',
            'results' => $deposito
        ]);
    }


    public function findActivo(Request $req){
        
        $depositos = Deposito::where('activo',1)->first();

        return response()->json([
            'success' => true,
            'message' => 'Depositos encontrados',
            'results' => $depositos
        ]);
    }

    public function activar(Request $req){
        
        $validator = Validator::make($req->all(), [
            'id' => 'required|exists:depositos,id'
        ]);
        if ($validator->fails()) 
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        
    
        DB::transaction(function () use ($req) {
            // Desactivar todos
            Deposito::query()->update(['activo' => 0]);
            
            // Activar el seleccionado
            Deposito::where('id', $req->id)->update(['activo' => 1]);
        });
    
        $deposito = Deposito::find($req->id);
    
        return response()->json([
            'success' => true,
            'message' => 'Depósito activado correctamente',
            'results' => $deposito
        ]);
    }
}
