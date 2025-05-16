<?php

namespace App\Http\Controllers\Pedido;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Illuminate\Http\Request;

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
                ]
            ]
        ]);
    }

    public function lucros()
    {
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
}
