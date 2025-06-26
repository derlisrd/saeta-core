<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Cliente\ClientesController;
use App\Http\Controllers\Config\ConfigurarController;
use App\Http\Controllers\Config\EmpresaController;
use App\Http\Controllers\Config\ImpresorasController;
use App\Http\Controllers\Config\SucursalController;
use App\Http\Controllers\Credito\CreditosController;
use App\Http\Controllers\Factura\FacturasController;
use App\Http\Controllers\Factura\FormasPagosController;
use App\Http\Controllers\Factura\ImpuestosController;
use App\Http\Controllers\Factura\MonedaController;
use App\Http\Controllers\Pedido\EstadisticasController;
use App\Http\Controllers\Pedido\PedidosController;
use App\Http\Controllers\Permiso\PermisosController;
use App\Http\Controllers\Producto\CategoriasController;
use App\Http\Controllers\Producto\DepositosController;
use App\Http\Controllers\Producto\MedidasController;
use App\Http\Controllers\Producto\ProductosController;
use App\Http\Controllers\Producto\StockController;
use App\Http\Controllers\User\UserController;
//use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;


Route::post('login', [AuthController::class, 'login']);

Route::prefix('/password')->group(function () {
    Route::post('send-code', [PasswordResetController::class, 'sendResetCode']);
    Route::post('verify-code', [PasswordResetController::class, 'verifyCode']);
    Route::post('reset', [PasswordResetController::class, 'resetPassword']);
});

Route::get('/config', [ConfigurarController::class, 'verificar']);

//Authenticate::using('api')
Route::middleware(['auth:api'])->group(function () {

    Route::prefix('/users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->middleware('permiso:users,ver');
        Route::post('/create', [UserController::class, 'create'])->middleware('permiso:users,crear');
        Route::post('/reset-password', [UserController::class, 'resetPassword'])->middleware('permiso:users,reset_password');
    });

    Route::prefix('permisos')->group(function () {
        Route::get('/users-administradores', [PermisosController::class, 'administradores']); // Todos los permisos disponibles
        Route::get('/', [PermisosController::class, 'index']); // Todos los permisos disponibles
        Route::get('/by-user/{id}', [PermisosController::class, 'permisosByUser']); // Todos los permisos disponibles
        Route::post('/asignar', [PermisosController::class, 'asignar']); // Asignar permisos
        Route::post('/revocar', [PermisosController::class, 'revocar']); // Revocar permisos
    })->middleware('permiso:permisos,asignar');



    Route::prefix('/categorias')->group(function () {
        Route::get('/', [CategoriasController::class, 'index'])->middleware('permiso:categorias,ver');
        Route::post('/', [CategoriasController::class, 'store'])->middleware('permiso:categorias,guardar');
        Route::put('/{id}', [CategoriasController::class, 'update'])->middleware('permiso:categorias,actualizar');
        Route::delete('/{id}', [CategoriasController::class, 'destroy'])->middleware('permiso:categorias,eliminar');
    });

    Route::prefix('productos')->group(function () {
        Route::get('/consultar-por-deposito', [ProductosController::class, 'consultarPorDeposito']);
        Route::get('/verificar/{codigo}', [ProductosController::class, 'verificarCodigoDisponible']);
        Route::get('/', [ProductosController::class, 'index']);
        Route::get('/search', [ProductosController::class, 'search']);
        Route::get('/search-por-deposito', [ProductosController::class, 'searchPorDeposito']);
        Route::get('/deposito/{id}', [ProductosController::class, 'productosPorDeposito']);
        Route::get('/find/{id}', [ProductosController::class, 'find']);
        Route::post('/', [ProductosController::class, 'store']);
        Route::put('/{id}', [ProductosController::class, 'update']);
        Route::delete('/{id}', [ProductosController::class, 'destroy']);
    });

    Route::prefix('formas-pago')->group(function () {
        Route::get('/', [FormasPagosController::class, 'index']);
        Route::post('/', [FormasPagosController::class, 'store']);
    });


    Route::prefix('medidas')->group(function () {
        Route::get('/', [MedidasController::class, 'index']);
        Route::post('/', [MedidasController::class, 'store']);
        Route::put('/{id}', [MedidasController::class, 'update']);
    });

    Route::prefix('stock')->group(function () {
        Route::get('/consultar', [StockController::class, 'consultarStock']);
        Route::post('/', [StockController::class, 'add']);
        Route::put('/corregir', [StockController::class, 'corregir']);
    });

    Route::prefix('depositos')->group(function () {
        Route::get('/', [DepositosController::class, 'index']);
        Route::post('/', [DepositosController::class, 'addDeposito']);
        Route::put('/{id}', [DepositosController::class, 'update']);
        Route::get('/productos', [DepositosController::class, 'productosPorDeposito']);
    });

    Route::prefix('facturas')->group(function () {
        Route::post('/pedido/{id}', [FacturasController::class, 'generarFacturaPedido']);
        Route::get('/', [FacturasController::class, 'index']);
        Route::get('/{id}', [FacturasController::class, 'find']);
        Route::post('/', [FacturasController::class, 'store']);
        Route::put('/{id}', [FacturasController::class, 'update']);
        Route::delete('/{id}', [FacturasController::class, 'destroy']);
    });

    Route::prefix('clientes')->group(function () {
        Route::get('/', [ClientesController::class, 'index']);
        Route::get('/documento/{doc}', [ClientesController::class, 'porDocumento']);
        Route::get('/search', [ClientesController::class, 'search']);
        Route::post('/', [ClientesController::class, 'store']);
    });
    Route::prefix('impuestos')->group(function () {
        Route::get('/', [ImpuestosController::class, 'index']);
    });

    Route::prefix('monedas')->group(function () {
        Route::get('/', [MonedaController::class, 'index']);
        Route::post('/', [MonedaController::class, 'store']);
        Route::put('/{id}', [MonedaController::class, 'update']);
    });
    Route::prefix('impresoras')->group(function () {
        Route::get('/', [ImpresorasController::class, 'index']);
        Route::post('/', [ImpresorasController::class, 'store']);
        Route::put('/{id}', [ImpresorasController::class, 'update']);
    });


    Route::prefix('estadisticas')->group(function () {
        Route::get('/pedidos', [EstadisticasController::class, 'pedidos']);
        Route::get('/lucros', [EstadisticasController::class, 'lucros']);
        Route::get('/producto/{id}', [EstadisticasController::class, 'producto']);
    });
    Route::prefix('pedidos')->group(function () {
        Route::get('/', [PedidosController::class, 'index']);
        Route::get('/search', [PedidosController::class, 'index']);
        //Route::get('/{id}',[PedidosController::class,'find']);
        Route::post('/send-email-recibo/{id}', [PedidosController::class, 'sendEmailRecibo']);
        Route::post('/', [PedidosController::class, 'crearPedidoEnMostrador']);
        Route::put('/cambiar-estado/{id}', [PedidosController::class, 'cambiarEstado']);
    });




    Route::prefix('creditos')->group(function () {
        Route::get('/', [CreditosController::class, 'index']);
        Route::get('/a-cobrar', [CreditosController::class, 'aCobrar']);
        Route::post('/cobrar', [CreditosController::class, 'cobrar']);
    });

    Route::prefix('config')->group(function () {
        Route::get('/empresa', [EmpresaController::class, 'index']);
        Route::put('/empresa', [EmpresaController::class, 'update']);
    });

    Route::prefix('sucursales')->group(function () {
        Route::get('/', [SucursalController::class, 'index']);
    });


    Route::get('/refresh-token', [AuthController::class, 'refreshToken']);
    Route::get('/me', [UserController::class, 'me']);
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/check', [AuthController::class, 'check']);
});



Route::fallback(function () {return response()->json(['success' => false, 'message' => 'Not found route.'], 404);});
