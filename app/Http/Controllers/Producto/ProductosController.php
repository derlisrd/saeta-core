<?php

namespace App\Http\Controllers\Producto;

use App\Http\Controllers\Controller;
use App\Models\Atributo;
use App\Models\AtributoValor;
use App\Models\Producto;
use App\Models\ProductoAtributoValor;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductosController extends Controller
{

    public function find($id)
    {
        $result = Producto::findOrFail($id);
        return response()->json([
            'success' => true,
            'message' => '',
            'results' => $result
        ]);
    }

    // un solo producto
    public function consultarPorDeposito(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'deposito_id' => 'nullable|exists:depositos,id',
            'cantidad' => 'numeric|gt:0',
            'codigo' => 'required|exists:productos,codigo'
        ], [
            'codigo.exists' => 'El codigo de producto no existe',
            'deposito_id.exists' => 'El depósito seleccionado no existe',
            'cantidad.gt' => 'La cantidad debe ser mayor a cero'
        ]);

        if ($validator->fails()) 
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'results' => null
            ], 400);
        

        // Consulta optimizada con todos los campos necesarios
        $query = Producto::select([
            'productos.id',
            'productos.codigo',
            'productos.created_at',
            'productos.nombre',
            'productos.precio_normal',
            'productos.precio_minimo',
            'productos.precio_descuento',
            'productos.descripcion',
            'productos.disponible',
            'productos.tipo',
            'productos.valor_comision',
            'productos.porcentaje_comision',
            'productos.costo',
            'productos.category_id',
            'productos.impuesto_id',
            'productos.medida_id'
        ])
            ->leftJoin('stocks as s', 'productos.id', '=', 's.producto_id')
            ->addSelect('s.cantidad', 's.deposito_id as stock_deposito_id')
            ->where('productos.codigo', $req->codigo);

        // Filtrar por depósito si se especifica
        if ($req->deposito_id) {
            $query->where('s.deposito_id', $req->deposito_id);
        }

        $producto = $query->first();

        if (!$producto) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado',
                'results' => null
            ], 404);
        }

        // Preparar respuesta base con todos los campos
        $resultado = [
            'id' => $producto->id,
            'producto_id' => $producto->id,
            'codigo' => $producto->codigo,
            'created_at' => $producto->created_at,
            'nombre' => $producto->nombre,
            'descripcion' => $producto->descripcion,
            'precio_normal' => $producto->precio_normal,
            'precio_minimo' => $producto->precio_minimo,
            'precio_descuento' => $producto->precio_descuento,
            'valor_comision' => $producto->valor_comision,
            'disponible' => $producto->disponible,
            'tipo' => $producto->tipo,
            'costo' => $producto->costo,
            'category_id' => $producto->category_id,
            'impuesto_id' => $producto->impuesto_id,
            'medida_id' => $producto->medida_id,
            'cantidad' => $producto->tipo == 2 ? 0 : ($producto->cantidad ?? 0),
            'deposito_id' => $producto->tipo == 2 ? null : $producto->stock_deposito_id,
        ];

        // Lógica específica por tipo de producto
        if ($producto->tipo == 2) { // Servicio
            $resultado['cantidad'] = 0;
            $resultado['deposito_id'] = null;

            return response()->json([
                'success' => true,
                'message' => '',
                'results' => $resultado
            ]);
        }

        // Validaciones para artículos (tipo = 1)
        if ($producto->tipo == 1) {
            $validacionStock = $this->validarStock($producto, $req->cantidad);

            if (!$validacionStock['valido']) {
                return response()->json([
                    'success' => false,
                    'message' => $validacionStock['mensaje'],
                    'results' => null
                ], 400);
            }
        }

        $resultado['cantidad'] = $producto->cantidad ?? 0;
        $resultado['deposito_id'] = $producto->stock_deposito_id;

        return response()->json([
            'success' => true,
            'message' => '',
            'results' => $resultado
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
            $limit = $request->query('limit', 240);
            $page = $request->query('page', 1);
            $offset = ($page - 1) * $limit;

            $results = Producto::orderByDesc('id')
                //->where('like','%'.$request->q ?? ''.'%')
                ->with('images')
                ->offset($offset)
                ->limit($limit)
                ->select(
                    'productos.id',
                    'productos.codigo',
                    'productos.created_at',
                    'productos.nombre',
                    'productos.precio_descuento',
                    'productos.precio_normal',
                    'productos.precio_minimo',
                    'productos.descripcion',
                    'productos.disponible',
                    'productos.tipo',
                    'productos.costo',
                    'productos.category_id',
                    'productos.impuesto_id',
                    'productos.medida_id',
                )
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

    public function searchPorDeposito(Request $request)
    {
        $query = Producto::query();
        //$query->join('stocks as s', 'productos.id', '=', 's.producto_id');
        $query->where('productos.nombre', 'like', '%' . $request->q . '%');
        $query->orWhere('productos.codigo', 'like', '%' . $request->q . '%');
        $query->limit(50);
        $query->select(
            'productos.id',
            'productos.codigo',
            'productos.created_at',
            'productos.nombre',
            'productos.precio_descuento',
            'productos.valor_comision',
            'productos.porcentaje_comision',
            'productos.precio_normal',
            'productos.precio_minimo',
            'productos.descripcion',
            'productos.disponible',
            'productos.tipo',
            'productos.costo',
            'productos.category_id',
            'productos.impuesto_id',
            'productos.medida_id',

        );
        $results = $query->get();


        return response()->json([
            'success' => true,
            'message' => '',
            'results' => $results
        ]);
    }


    public function productosPorDeposito(Request $request, $id)
    {
        $query = Producto::query();
        $query->join('stocks as s', 'productos.id', '=', 's.producto_id');
        $query->where('productos.nombre', 'like', '%' . $request->q . '%');
        $query->orWhere('productos.codigo', 'like', '%' . $request->q . '%');
        $query->where('s.deposito_id', $id);
        $query->limit(240);
        $query->orderByDesc('productos.id');
        $query->select(
            'productos.id',
            'productos.codigo',
            'productos.created_at',
            'productos.nombre',
            's.cantidad',
            'productos.precio_normal',
            'productos.precio_minimo',
            'productos.precio_descuento',
            'productos.descripcion',
            'productos.disponible',
            'productos.tipo',
            'productos.costo',
            'productos.category_id',
            'productos.impuesto_id',
            'productos.medida_id',

        );
        $results = $query->get();


        return response()->json([
            'success' => true,
            'message' => '',
            'results' => $results
        ]);
    }
    public function search(Request $request)
    {
        $query = Producto::query();
        $query->where('nombre', 'like', '%' . $request->q . '%');
        $query->orWhere('codigo', 'like', '%' . $request->q . '%');

        $results = $query->get();
        return response()->json([
            'success' => true,
            'results' => $results
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
            'precio_descuento' => 'nullable|numeric',
            'stock' =>'nullable|numeric|min:0',
            'deposito_id'=>'nullable|numeric|exists:depositos,id',
            'images' => 'nullable|array|max:6',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'atributos' => 'nullable|array',
            'atributos.*.nombre' => 'required',
            'atributos.*.opciones' => 'array',
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

        try {
            $producto = Producto::create($datos);
            if (!empty($req->stock)) {
                /* foreach ($req->stock as $stock) {
                    
                } */
                $producto->stock()->create([
                    'producto_id' => $producto->id,
                    'deposito_id' => $req->deposito_id,
                    'cantidad' => $req->stock
                ]);
            }
            if (!empty($req->atributos)) {
                foreach ($req->atributos as $itemAtributo) {
                    $atributo = Atributo::create([
                        'nombre' => $itemAtributo['nombre']
                    ]);
                    foreach ($itemAtributo['opciones'] as $itemValor) {
                        $valor = AtributoValor::create([
                            'atributo_id' => $atributo->id,
                            'valor' => $itemValor
                        ]);
                        ProductoAtributoValor::create([
                            'producto_id' => $producto->id,
                            'atributo_id' => $atributo->id,
                            'atributo_valor_id' => $valor->id
                        ]);
                    }
                }
            }

            if ($req->hasFile('images')) {
                $imageUploadService = new ImageUploadService();
                foreach ($req->file('images') as $image) {
                    $url = $imageUploadService->subir($image, $producto->id); // Guarda en /public/{id}/time.jpg
                    $thumb = $imageUploadService->crearMiniaturaCuadrada($image, $producto->id); // Guarda en /public/{id}/thumb.jpg
                    $producto->images()->create([
                        'producto_id' => $producto->id,
                        'miniatura' => $thumb,
                        'url' => $url
                    ]);
                }
            }


            return response()->json([
                'success' => true,
                'message' => 'Producto creado',
                'results' => $producto
            ]);
        } catch (\Throwable $th) {
            throw $th;
            Log::error($th);
        }
    }

    public function update(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'impuesto_id' => 'required',
            'category_id' => 'nullable|exists:categories,id',
            'medida_id' => 'nullable|exists:medidas,id',
            'nombre' => 'required',
            'costo' => 'required|numeric',
            'precio_normal' => 'required|numeric',
            'precio_minimo' => 'required|numeric',
            'preguntar_precio' => 'nullable|boolean',
            'disponible' => 'required',
            'tipo' => 'required',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'atributos' => 'nullable|array',
            'atributos.*.nombre' => 'required',
            'atributos.*.opciones' => 'array',
        ]);
        if ($validator->fails())
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 400);

        $user = $req->user();
        $datos = [
            'category_id' => $req->category_id,
            'medida_id' => $req->medida_id,
            'impuesto_id' => $req->impuesto_id,
            'modificado_por' => $user->id,
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




    /**
     * Validar stock disponible para artículos
     */
    private function validarStock($producto, $cantidadSolicitada)
    {
        if (is_null($producto->cantidad)) {
            return [
                'valido' => false,
                'mensaje' => 'El producto existe, pero no tiene stock en el depósito seleccionado.'
            ];
        }

        if ($producto->cantidad <= 0) {
            return [
                'valido' => false,
                'mensaje' => 'El producto no tiene stock disponible.'
            ];
        }

        if ($producto->cantidad < $cantidadSolicitada) {
            return [
                'valido' => false,
                'mensaje' => "Stock insuficiente. Disponible: {$producto->cantidad}, Solicitado: {$cantidadSolicitada}"
            ];
        }

        return ['valido' => true];
    }
}
