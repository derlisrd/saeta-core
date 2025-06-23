{{-- resources/views/recibos/printable.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo - {{ $pedido->id ?? 'Sin código' }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Courier New', monospace !important;
            background-color: #fff;
            color: #000 !important;
            padding: 10px;
            font-size: 12px;
        }
        
        .header {
            line-height: 0.1;
            margin-bottom: 10px;
        }
        
        .header h4 {
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .header h5 {
            margin-bottom: 3px;
            font-size: 11px;
        }
        
        .dashed-border {
            border-top: 1px dashed #ccc;
            margin: 8px 0;
        }
        
        .customer-info {
            margin-bottom: 16px;
        }
        
        .customer-info small {
            font-size: 10px;
        }
        
        .items-grid {
            display: grid;
            grid-template-columns: 1fr auto auto;
            column-gap: 6px;
            row-gap: 4px;
            margin-bottom: 16px;
        }
        
        .items-grid .header-item {
            font-weight: bold;
            font-size: 10px;
        }
        
        .items-grid .full-width {
            grid-column: 1 / -1;
        }
        
        .items-grid .text-right {
            text-align: right;
        }
        
        .items-grid .item-row {
            border-bottom: 1px solid #000;
            padding-bottom: 2px;
            font-size: 10px;
        }
        
        .payment-methods {
            margin-top: 16px;
        }
        
        .payment-methods small {
            line-height: 0.5;
            font-weight: bold;
            font-size: 10px;
        }
        
        .payment-methods ul {
            margin-left: 15px;
            margin-top: 5px;
        }
        
        .payment-methods li {
            font-size: 10px;
            margin-bottom: 2px;
        }
        
        .totals {
            text-align: right;
            margin-top: 16px;
            display: flex;
            flex-direction: column;
            font-weight: bold;
        }
        
        .totals small {
            font-size: 10px;
            margin-bottom: 2px;
        }
        
        .thank-you {
            margin-top: 16px;
            text-align: center;
            font-size: 11px;
        }
        
        .no-data {
            text-align: center;
            padding: 20px;
            font-size: 14px;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    @if(!$pedido)
        <div class="no-data">
            No hay datos del pedido para mostrar.
        </div>
    @else
        {{-- Header con información de la empresa --}}
        <div class="header">
            <h4>{{ $empresa->nombre ?? 'EMPRESA' }}</h4>
            <h5>{{ $empresa->direccion ?? 'DIRECCIÓN' }} TEL: {{ $empresa->telefono ?? 'TELÉFONO' }}</h5>
            <h5>FECHA: {{ \Carbon\Carbon::parse($pedido->created_at)->format('d/m/Y') }}</h5>
            <h5>CONDICION: {{ $pedido->condicion == 1 ? 'CREDITO' : 'CONTADO' }}</h5>
            <h5>CODIGO: {{ $pedido->id }}</h5>
        </div>
        
        <div class="dashed-border"></div>
        
        {{-- Información del cliente --}}
        <div class="customer-info">
            <small>CI/RUC: {{ $pedido->doc ?? 'x' }}</small><br>
            <small>CLIENTE: {{ $pedido->razon_social ?? 'x' }}</small>
        </div>
        
        <div class="dashed-border"></div>
        
        {{-- Grid de items --}}
        <div class="items-grid">
            {{-- Headers --}}
            <small class="header-item full-width">Codigo</small>
            <small class="header-item">Descrip.</small>
            <small class="header-item text-right">Cant</small>
            <small class="header-item text-right">Prec.</small>
            
            {{-- Items --}}
            @if($pedido->items && count($pedido->items) > 0)
                @foreach($pedido->items as $item)
                    {{-- Código ocupa toda la fila --}}
                    <small class="full-width">{{ $item->codigo }}</small>
                    
                    {{-- Descripción, cantidad y precio --}}
                    <small class="item-row">
                        {{ strlen($item->nombre) > 28 ? substr($item->nombre, 0, 28) : $item->nombre }}
                    </small>
                    <small class="item-row text-right">{{ $item->cantidad }}</small>
                    <small class="item-row text-right">{{ number_format($item->precio, 0, ',', '.') }}</small>
                @endforeach
            @endif
        </div>
        
        <div class="dashed-border"></div>
        
        {{-- Formas de pago --}}
        @if($pedido->formas_pago_pedido && count($pedido->formas_pago_pedido) > 0)
            <div class="payment-methods">
                <small>Formas de Pago</small>
                <ul>
                    @foreach($pedido->formas_pago_pedido as $pago)
                        <li>{{ $pago->abreviatura }}: {{ number_format(floatval($pago->monto), 0, ',', '.') }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        {{-- Totales --}}
        <div class="totals">
            <small>SUBTOTAL: {{ number_format($pedido->total, 0, ',', '.') }}</small>
            <small>DESCUENTO: -{{ number_format($pedido->descuento, 0, ',', '.') }}</small>
            <small>TOTAL: {{ number_format($pedido->importe_final, 0, ',', '.') }}</small>
        </div>
        
        <p class="thank-you">Gracias por su compra!</p>
    @endif
</body>
</html>