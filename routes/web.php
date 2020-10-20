

<?php
use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request\CategoriaFormRequest;

//use App\Http\Controllers\CategoriaController;

use Illuminate\Http\CategoriaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/',function(){
	return view('auth/login');
});
Route::get('/dashboard',function(){
	return view('welcome');
});

Route::get('/', function () {
    return view('welcome');
});*/

Route::resource('almacen/categoria','App\Http\Controllers\CategoriaController');
Route::resource('almacen/articulo','App\Http\Controllers\ArticuloController');
Route::resource('ventas/cliente','App\Http\Controllers\ClienteController');
Route::resource('compras/proveedor','App\Http\Controllers\ProveedorController');
Route::resource('compras/ingreso','App\Http\Controllers\IngresoController');
Route::resource('ventas/venta','App\Http\Controllers\VentaController');

/*Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');*/
/*Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
    return view('welcome');
});*/


