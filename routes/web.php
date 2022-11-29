<?php

use App\Http\Controllers\AptoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogoutController;
use App\Http\Requests\RegisterRequest;
use App\Model\User;
use App\Http\Controllers\VisitanteController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\EventoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|

Route::get('/', function () {
    return view('welcome');
});
*/


//Route pagina principal
Route::get('/' , function(){
    return view('pagina.index');
});


/*
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/home' , [HomeController::class, 'index']);
});
*/

//Va a ejecutar el metodo de registercontroller
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/register' , [RegisterController::class, 'show'])->name('register.form');


//Crear la ruta para login usuario
Route::get('/login', function () {
    return view('auth.login');
});
//Va a ejecutar el metodo de logincontroller
Route::post('/login', [LoginController::class, 'login']);
Route::get('/login' , [LoginController::class, 'show'])->name('login.form');


//Rura cuando el usuario se autentica
Route::get('/home' , [HomeController::class, 'index']);
//Ruta para cerra sesion
Route::get('/logout' , [LogoutController::class, 'logout']);


// rutas para usuarios

Route::resource('usuarios', 'UsuarioController');
Route::get('usuarios/{usuario}/habilitar' , "UsuarioController@habilitar")->middleware('sesiones');
Route::get('usuarios/{usuario}/habilitar' , "UsuarioController@habilitar")->middleware('sesiones');
Route::get('usuarios/{usuario}/habilitar' , "UsuarioController@habilitar");


Route::get('/usuarios', [UsuarioController::class, 'index']);
Route::get('usuarios/create', [UsuarioController::class, 'create'])->name('usuario.create');
Route::post('usuarios/store', [UsuarioController::class, 'store'])->name('usuario.store');
Route::delete('usuarios/destroy/{usuario}', [UsuarioController::class, 'destroy'])->name('usuario.destroy');
Route::get('/usuarios/view/{usuario}', [UsuarioController::class, 'show'])->name('usuario.show');
Route::post('/usuarios/edit/{usuario}', [UsuarioController::class, 'edit'])->name('usuario.edit'); 
Route::post('usuarios/update', [UsuarioController::class, 'update'])->name('usuario.update');



// rutas para visitantes
Route::get('/visitantes', [VisitanteController::class, 'index']);
Route::get('visitantes/create', [VisitanteController::class, 'create'])->name('visitante.create');
Route::post('visitantes/store', [VisitanteController::class, 'store'])->name('visitante.store');
Route::delete('visitantes/destroy/{visitante}', [VisitanteController::class, 'destroy'])->name('visitante.destroy');
Route::get('/visitantes/view/{visitante}', [VisitanteController::class, 'show'])->name('visitante.show');
Route::post('/visitantes/edit/{visitante}', [VisitanteController::class, 'edit'])->name('visitante.edit'); 
Route::post('visitantes/update', [VisitanteController::class, 'update'])->name('visitante.update');

//Rutas para apartamento
Route::get('/apartamentos', [AptoController::class, 'index']);
Route::get('apartamentos/create', [AptoController::class, 'create'])->name('apartamento.create');
Route::post('apartamentos/store', [AptoController::class, 'store'])->name('apartamento.store');
Route::delete('apartamentos/destroy/{apartamento}', [AptoController::class, 'destroy'])->name('apartamento.destroy');
Route::get('/apartamentos/view/{apartamento}', [AptoController::class, 'show'])->name('apartamento.show');
Route::post('/apartamentos/edit/{apartamento}', [AptoController::class, 'edit'])->name('apartamento.edit'); 
Route::post('apartamentos/update', [AptoController::class, 'update'])->name('apartamento.update');

//Rutas para club house
Route::get('/clubs', [ClubController::class, 'index']);
Route::get('clubs/create', [ClubController::class, 'create'])->name('club.create');
Route::post('clubs/store', [ClubController::class, 'store'])->name('club.store');
Route::delete('clubs/destroy/{club}', [ClubController::class, 'destroy'])->name('club.destroy');
Route::get('/clubs/view/{club}', [ClubController::class, 'show'])->name('club.show');
Route::get('/clubs/edit/{id_club}', [ClubController::class, 'edit'])->name('club.edit'); 
Route::put('clubs/update', [ClubController::class, 'update'])->name('club.update');


//Rutas para vehiculos
Route::get('/vehiculos', [VehiculoController::class, 'index']);
Route::get('vehiculos/create', [VehiculoController::class, 'create'])->name('vehiculo.create');
Route::post('vehiculos/store', [VehiculoController::class, 'store'])->name('vehiculo.store');
Route::delete('vehiculos/destroy/{vehiculo}', [VehiculoController::class, 'destroy'])->name('vehiculo.destroy');
Route::get('/vehiculos/view/{vehiculo}', [VehiculoController::class, 'show'])->name('vehiculo.show');
Route::post('/vehiculos/edit/{vehiculo}', [VehiculoController::class, 'edit'])->name('vehiculo.edit'); 
Route::post('vehiculos/update', [VehiculoController::class, 'update'])->name('vehiculo.update');


Route::group(['middleware' => ['auth']], function(){

    Route::get('/evento', [EventoController::class, 'index']);
    Route::get('/evento/mostrar', [EventoController::class, 'show']);
    Route::post('/evento/agregar', [EventoController::class, 'store']);
    Route::post('/evento/editar/{id}', [EventoController::class, 'edit']);
    Route::post('/evento/actualizar/{evento}', [EventoController::class, 'update']);
    Route::post('/evento/borrar/{id}', [EventoController::class, 'destroy']);
});

//Rutas de pdf
Route::get('pdfresidente', 'PDFControllerResidente@pdf');
Route::get('pdfvisitantes', 'PDFControllerVisitante@pdf');