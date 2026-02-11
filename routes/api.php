<?php
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\EdificioController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\PrioridadController;
use App\Http\Controllers\ProvCategoriaController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\TipoEspacioController;
use App\Http\Controllers\UnidadEspacioController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\UsuRolController;
use App\Http\Controllers\LogAccesoController;
use App\Http\Controllers\EspacioRolController;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

use App\Http\Controllers\Api\PersonaController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\FrecuenciaController;
use App\Http\Controllers\ActividadCabeceraController;

// API para obtener la fecha y hora actuales con la zona horaria configurada
Route::get('/datetime', function () {
    return response()->json([
        'datetime' => Carbon::now()->toDateTimeString(),
        'timezone' => config('app.timezone'),
    ]);
});

// Registro de usuario
/*Route::post('/register', [AuthController::class, 'register']);

// Login de usuario
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);

    // API para obtener todas las personas
    Route::get('/personas', [PersonaController::class, 'index']);
});*/


Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('auth/select-building', [\App\Http\Controllers\Auth\BuildingSelectionController::class, 'select']
);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('perfil', fn ($request) => $request->user()->load('espacioRoles.rol'));

    Route::apiResource('usuarios', UsuarioController::class);
    Route::apiResource('roles', RolController::class);

    Route::post('usu_roles/assign', [UsuRolController::class, 'assign']);
    Route::post('usu_roles/remove', [UsuRolController::class, 'remove']);
    // API para obtener todas las personas
    Route::get('/personas', [PersonaController::class, 'index']);

    Route::apiResource('empresas', EmpresaController::class);
    Route::apiResource('edificios', EdificioController::class);
    Route::apiResource('tipo-espacios', TipoEspacioController::class);
    Route::apiResource('unidad-espacio', UnidadEspacioController::class);
    Route::apiResource('roles', RolController::class);
    Route::apiResource('log-acceso', LogAccesoController::class);

    Route::get('espacio-roles', [EspacioRolController::class,'index']);
    Route::post('espacio-roles', [EspacioRolController::class,'store']);
    Route::delete('espacio-roles', [EspacioRolController::class,'destroy']);

    Route::apiResource('proveedores', ProveedorController::class);
    Route::apiResource('categorias', CategoriaController::class);
    Route::apiResource('prov-categorias', ProvCategoriaController::class)->only(['index', 'store', 'destroy']);
    Route::apiResource('prioridades', PrioridadController::class);

    Route::apiResource('frecuencias', FrecuenciaController::class);
    Route::apiResource('estados', EstadoController::class);

    Route::get('/actividades', [ActividadCabeceraController::class, 'index']);
    Route::post('/actividades', [ActividadCabeceraController::class, 'store']);

    Route::post(
        '/actividades/{idActividadCab}/cambiar-estado',
        [FlujoActividadController::class, 'cambiarEstado']
    );
})
;



