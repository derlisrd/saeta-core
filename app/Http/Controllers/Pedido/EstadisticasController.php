<?php

namespace App\Http\Controllers\Pedido;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Models\PedidoItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EstadisticasController extends Controller
{
    public function pedidos()
    {
        $ayer = now()->subDay()->startOfDay();
        $finAyer  = now()->subDay()->endOfDay();
        $hoy = now()->startOfDay();
        $finHoy = now()->endOfDay();
        $inicioSemana = now()->startOfWeek();
        $finSemana = now()->endOfWeek();
        $inicioMes = now()->startOfMonth();
        $finMes = now()->endOfMonth();

        // Para la semana pasada
        $inicioSemanaPasada = now()->subWeek()->startOfWeek();
        $finSemanaPasada = now()->subWeek()->endOfWeek();

        // Para el mes pasado
        $inicioMesPasado = now()->subMonth()->startOfMonth();
        $finMesPasado = now()->subMonth()->endOfMonth();

        $estadisticasAyer = Pedido::whereBetween('created_at', [$ayer, $finAyer])
        ->selectRaw('count(*) as cantidad_pedidos, sum(importe_final) as importe_final_total, sum(descuento) as descuento_total')
        ->first();

        $estadisticasHoy = Pedido::whereBetween('created_at', [$hoy, $finHoy])
            ->selectRaw('count(*) as cantidad_pedidos, sum(importe_final) as importe_final_total, sum(descuento) as descuento_total')
            ->first();

        $estadisticasSemana = Pedido::whereBetween('created_at', [$inicioSemana, $finSemana])
            ->selectRaw('count(*) as cantidad_pedidos, sum(importe_final) as importe_final_total, sum(descuento) as descuento_total')
            ->first();

        $estadisticasMes = Pedido::whereBetween('created_at', [$inicioMes, $finMes])
            ->selectRaw('count(*) as cantidad_pedidos, sum(importe_final) as importe_final_total, sum(descuento) as descuento_total')
            ->first();

            // Estadísticas de la semana pasada
            $estadisticasSemanaPasada = Pedido::whereBetween('created_at', [$inicioSemanaPasada, $finSemanaPasada])
            ->selectRaw('count(*) as cantidad_pedidos, sum(importe_final) as importe_final_total, sum(descuento) as descuento_total')
            ->first();

        // Estadísticas del mes pasado
        $estadisticasMesPasado = Pedido::whereBetween('created_at', [$inicioMesPasado, $finMesPasado])
            ->selectRaw('count(*) as cantidad_pedidos, sum(importe_final) as importe_final_total, sum(descuento) as descuento_total')
            ->first();

        return response()->json([
            'success' => true,
            'message' => 'Estadísticas de pedidos',
            'results' => [
                'ayer' => [
                    'cantidad_pedidos' => $estadisticasAyer ? $estadisticasAyer->cantidad_pedidos : 0,
                    'importe_final_total' => $estadisticasAyer ? $estadisticasAyer->importe_final_total : 0,
                    'descuento_total' => $estadisticasAyer ? $estadisticasAyer->descuento_total : 0
                ],
                'hoy' => [
                    'cantidad_pedidos' => $estadisticasHoy ? $estadisticasHoy->cantidad_pedidos : 0,
                    'importe_final_total' => $estadisticasHoy ? $estadisticasHoy->importe_final_total : 0,
                    'descuento_total' => $estadisticasHoy ? $estadisticasHoy->descuento_total : 0
                ],
                'semana' => [
                    'cantidad_pedidos' => $estadisticasSemana ? $estadisticasSemana->cantidad_pedidos : 0,
                    'importe_final_total' => $estadisticasSemana ? $estadisticasSemana->importe_final_total : 0,
                    'descuento_total' => $estadisticasSemana ? $estadisticasSemana->descuento_total : 0
                ],
                'mes' => [
                    'cantidad_pedidos' => $estadisticasMes ? $estadisticasMes->cantidad_pedidos : 0,
                    'importe_final_total' => $estadisticasMes ? $estadisticasMes->importe_final_total : 0,
                    'descuento_total' => $estadisticasMes ? $estadisticasMes->descuento_total : 0
                ],
                'semana_pasada' => [ // Agregado semana pasada
                    'cantidad_pedidos' => $estadisticasSemanaPasada ? $estadisticasSemanaPasada->cantidad_pedidos : 0,
                    'importe_final_total' => $estadisticasSemanaPasada ? $estadisticasSemanaPasada->importe_final_total : 0,
                    'descuento_total' => $estadisticasSemanaPasada ? $estadisticasSemanaPasada->descuento_total : 0
                ],
                'mes_pasado' => [ // Agregado mes pasado
                    'cantidad_pedidos' => $estadisticasMesPasado ? $estadisticasMesPasado->cantidad_pedidos : 0,
                    'importe_final_total' => $estadisticasMesPasado ? $estadisticasMesPasado->importe_final_total : 0,
                    'descuento_total' => $estadisticasMesPasado ? $estadisticasMesPasado->descuento_total : 0
                ]
            ]
        ]);
    }

    public function lucros()
    {
        $ayer = now()->subDay()->startOfDay();
        $finAyer  = now()->subDay()->endOfDay();
        $hoyInicio = now()->startOfDay();
        $hoyFin = now()->endOfDay();
        $inicioSemana = now()->startOfWeek();
        $finSemana = now()->endOfWeek();
        $inicioMes = now()->startOfMonth();
        $finMes = now()->endOfMonth();

        // Función para calcular el lucro de una colección de pedidos optimizada
        $calcularLucroPedidosOptimizado = function ($pedidos) {
            $lucroTotal = 0;
            foreach ($pedidos as $pedido) {
                $costoPedido = 0;
                foreach ($pedido->items as $item) {
                    if ($item->producto) {
                        $costoPedido += $item->producto->costo * $item->cantidad;
                    }
                }
                $lucroTotal += $pedido->importe_final - $costoPedido;
            }
            return $lucroTotal;
        };

        // Obtener los pedidos con relaciones necesarias, seleccionando solo las columnas relevantes
        $pedidosAyer = Pedido::whereBetween('created_at', [$ayer, $finAyer])
            ->with(['items:pedido_id,producto_id,cantidad', 'items.producto:id,costo'])
            ->select('id', 'importe_final')
            ->get();
        $pedidosHoy = Pedido::whereBetween('created_at', [$hoyInicio, $hoyFin])
            ->with(['items:pedido_id,producto_id,cantidad', 'items.producto:id,costo'])
            ->select('id', 'importe_final')
            ->get();

        $pedidosSemana = Pedido::whereBetween('created_at', [$inicioSemana, $finSemana])
            ->with(['items:pedido_id,producto_id,cantidad', 'items.producto:id,costo'])
            ->select('id', 'importe_final')
            ->get();

        $pedidosMes = Pedido::whereBetween('created_at', [$inicioMes, $finMes])
            ->with(['items:pedido_id,producto_id,cantidad', 'items.producto:id,costo'])
            ->select('id', 'importe_final')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Lucro de pedidos',
            'results' => [
                'ayer' => [
                    'lucro_total' => $calcularLucroPedidosOptimizado($pedidosAyer),
                ],
                'hoy' => [
                    'lucro_total' => $calcularLucroPedidosOptimizado($pedidosHoy),
                ],
                'semana' => [
                    'lucro_total' => $calcularLucroPedidosOptimizado($pedidosSemana),
                ],
                'mes' => [
                    'lucro_total' => $calcularLucroPedidosOptimizado($pedidosMes),
                ]
            ]
        ]);
    }


    public function producto(Request $req){

        $validator = Validator::make($req->all(), [
            'desde' => 'required|date|format:Y-m-d',
            'hasta' => 'required|date|format:Y-m-d',
            'producto_id' => 'required|integer|exists:productos,id',
        ]);
        if ($validator->fails()) 
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        
        
        $id = $req->producto_id;
        $desde = $req->desde;
        $hasta = $req->hasta;

        // calcular el total de ventas de un producto en un rango de fechas
        $itemsVendidos = PedidoItems::where('producto_id', $id)->whereBetween('created_at', [$desde, $hasta])->get();
        $cantidad = 0;
        $lucro = 0;
        
        foreach ($itemsVendidos as $i) {
            $cantidad += $i->cantidad;
            $lucro += (($i->item->precio - $i->descuento) * $i->cantidad ) - ($i->producto->costo * $i->cantidad);
        }
        

        return response()->json([
            'success'=>true,
            'results'=>[
                'ventas'=> $itemsVendidos,
                'cantidad' => $cantidad,
                'lucro' => $lucro,
            ]
        ]);
    }


}

      



