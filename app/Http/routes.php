<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('auth/login'); //mostrar el formulario de acceso al sistema
});

//resourse(cual es la ruta(navegador)?, a que controlador se hará referencia cuando se ingrese la ruta en el navegador?)
Route::resource('/almacen/categoria', 'CategoriaController');
Route::resource('/almacen/articulo', 'ArticuloController');
Route::resource('/ventas/cliente', 'ClienteController');
Route::resource('/compras/proveedor', 'ProveedorController');
Route::resource('/compras/ingreso', 'IngresoController');
Route::resource('/ventas/venta', 'VentaController');
Route::resource('/seguridad/usuario', 'UsuarioController');
Route::get('/pdf', 'PDFController@PDF')->name('descargarPDF');
// Route::resource('/reportes/reporte', 'PDFController');

Route::auth();

Route::get('/home', 'HomeController@index');
Route::get('/{slug?}', 'HomeController@index'); //si la ruta no existe o no es una de las anteriores redirecciona al HomeController


