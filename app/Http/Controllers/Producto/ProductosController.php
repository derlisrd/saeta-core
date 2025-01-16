<?php

namespace App\Http\Controllers\Producto;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductosController extends Controller
{

    public function consultarPorDeposito(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'deposito_id' => 'nullable|exists:depositos,id',
            'cantidad' => 'numeric',
            'codigo' => 'required|exists:productos,codigo'
        ], [
            'codigo.exists' => 'El codigo de producto no existe',
            'deposito_id.exists' => 'El depósito seleccionado no existe'
        ]);
        if ($validator->fails())
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'results'=>null], 400);

        // Buscar el producto por código
        $producto = Producto::with(['stock' => function ($query) use ($req) {
            if ($req->deposito_id) {
                $query->where('deposito_id', $req->deposito_id);
            }
        }])->where('codigo', $req->codigo)->first();


        // Si el producto es un servicio (tipo = 2)
        if ($producto->tipo == 2) {
            return response()->json([
                'success' => true,
                'message'=>'',
                'results' => [
                    'id' => $producto->id,
                    'deposito_id' => null,
                    'impuesto_id' => $producto->impuesto_id,
                    'producto_id' => $producto->id,
                    'codigo' => $producto->codigo,
                    'nombre' => $producto->nombre,
                    'descripcion' => $producto->descripcion,
                    'costo' => $producto->costo,
                    'precio_normal' => $producto->precio_normal,
                    'precio_minimo' => $producto->precio_minimo,
                    'disponible' => $producto->disponible,
                    'tipo' => $producto->tipo,
                    'cantidad' => 0, // Los servicios no tienen cantidad
                ],
            ]);
        }

        // Verificar stock para artículos (tipo = 1)
        $stockDisponible = $producto->stock->first();

        if ($producto->tipo == 1) {
            if (!$stockDisponible) {
                return response()->json([
                    'success' => false,
                    'message' => 'El producto existe, pero no tiene stock en el depósito seleccionado.',
                    'results'=>null
                ],400);
            }

            if ($stockDisponible->cantidad <= 0 || $stockDisponible->cantidad < $req->cantidad) {
                return response()->json([
                    'success' => false,
                    'message' => 'El producto no tiene stock disponible.',
                    'results'=>null
                ], 400);
            }
        }

        // Retornar producto con stock
        return response()->json([
            'success' => true,
            'message'=>'',
            'results' => [
                'id' => $producto->id,
                'producto_id' => $producto->id,
                'deposito_id' => $stockDisponible ? $stockDisponible->deposito_id : null,
                'impuesto_id' => $producto->impuesto_id,
                'codigo' => $producto->codigo,
                'nombre' => $producto->nombre,
                'descripcion' => $producto->descripcion,
                'costo' => $producto->costo,
                'precio_normal' => $producto->precio_normal,
                'precio_minimo' => $producto->precio_minimo,
                'disponible' => $producto->disponible,
                'tipo' => $producto->tipo,
                'cantidad' => $stockDisponible ? $stockDisponible->cantidad : 0,
            ],
        ]);
    }


    public function verificarCodigoDisponible(string $codigo)
    {
        $validator = Validator::make(['codigo' => $codigo], [
            'codigo' => 'required'
        ]);
        if ($validator->fails())
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 400);

        $producto = Producto::where('codigo', $codigo)->first();
        if ($producto) {
            return response()->json([
                'success' => false,
                'message' => 'Código no disponible'
            ], 400);
        }
        return response()->json([
            'success' => true,
            'message' => 'Código disponible'
        ]);
    }

    public function index(Request $request)
    {
        try {

            $count = Producto::count();
            $limit = $request->query('limit', 120);
            $page = $request->query('page', 1);
            $offset = ($page - 1) * $limit;

            $results = Producto::orderBy('nombre', 'asc')
                //->where('like','%'.$request->q ?? ''.'%')
                ->offset($offset)
                ->limit($limit)
                ->get();

            return response()->json([
                'success' => true,
                'total' => $count,
                'results' => $results
            ]);
        } catch (\Throwable $th) {
            throw $th;
            return response()->json([
                'success' => false,
                'message' => 'Error de servidor. SEQ29'
            ], 500);
        }
    }

    public function find($id)
    {
        $results = Producto::find($id);
        if (!$results) {
            return response()->json([
                'success' => false,
                'results' => null,
                'message' => 'Producto no existe'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'results' => $results,
            'message' => ''
        ]);
    }

    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'impuesto_id' => 'required',
            'category_id' => 'nullable|exists:categories,id',
            'medida_id' => 'nullable|exists:medidas,id',
            'codigo' => 'required|unique:productos,codigo',
            'nombre' => 'required',
            'costo' => 'required|numeric',
            'precio_normal' => 'required|numeric',
            'precio_minimo' => 'required|numeric',
            'preguntar_precio' => 'nullable|boolean',
            'disponible' => 'required',
            'tipo' => 'required',
            'stock' => 'nullable|array',
            'stock.*.deposito_id' => 'exists:depositos,id',
            'stock.*.cantidad' => 'numeric|min:0',
        ]);
        if ($validator->fails())
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 400);

        $user = $req->user();
        $datos = [
            'category_id' => $req->category_id,
            'medida_id' => $req->medida_id,
            'impuesto_id' => $req->impuesto_id,
            'creado_por' => $user->id,
            'modificado_por' => $user->id,
            'codigo' => $req->codigo,
            'nombre' => $req->nombre,
            'descripcion' => $req->descripcion,
            'costo' => $req->costo,
            'modo_comision' => $req->modo_comision,
            'porcentaje_comision' => $req->porcentaje_comision,
            'valor_comision' => $req->valor_comision,
            'precio_normal' => $req->precio_normal,
            'precio_descuento' => $req->precio_descuento,
            'precio_minimo' => $req->precio_minimo,
            'preguntar_precio' => $req->preguntar_precio,
            'porcentaje_impuesto' => $req->porcentaje_impuesto,
            'disponible' => $req->disponible,
            'tipo' => $req->tipo,
            'notificar_minimo' => $req->notificar_minimo ?? 0,
            'cantidad_minima' => $req->cantidad_minima
        ];

        $producto = Producto::create($datos);
        if (!empty($req->stock)) {
            foreach ($req->stock as $stock) {
                $producto->stock()->create([
                    'producto_id' => $producto->id,
                    'deposito_id' => $stock['deposito_id'],
                    'cantidad' => $stock['cantidad']
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Producto creado',
            'results' => $producto
        ]);
    }

    public function update(Request $req, $id)
    {
        $user = $req->user();
        $datos = [
            'category_id' => $req->category_id,
            'medida_id' => $req->medida_id,
            'impuesto_id' => $req->impuesto_id,
            'modificado_por' => $user->id,
            'codigo' => $req->codigo,
            'nombre' => $req->nombre,
            'descripcion' => $req->descripcion,
            'costo' => $req->costo,
            'modo_comision' => $req->modo_comision,
            'porcentaje_comision' => $req->porcentaje_comision,
            'valor_comision' => $req->valor_comision,
            'precio_normal' => $req->precio_normal,
            'precio_descuento' => $req->precio_descuento,
            'precio_minimo' => $req->precio_minimo,
            'porcentaje_impuesto' => $req->porcentaje_impuesto,
            'disponible' => $req->disponible,
            'tipo' => $req->tipo,
            'preguntar_precio' => $req->preguntar_precio,
            'notificar_minimo' => $req->notificar_minimo,
            'cantidad_minima' => $req->cantidad_minima
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
            'success' => true,
            'message' => 'Producto modificado',
            'results' => $producto
        ]);
    }

    public function destroy($id)
    {
        try {
            $producto = Producto::find($id);
            $producto->destroy();

            return response()->json([
                'success' => true,
                'message' => 'Producto eliminado'
            ]);
        } catch (\Throwable $th) {
            throw $th;
            return response()->json([
                'success' => false,
                'message' => 'Error de servidor. SEQ132'
            ], 500);
        }
    }
}
