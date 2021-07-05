<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

# Route::get('peticion', accion);
Route::get('/saludo', function ()
{
    return 'Hola mundo desde Laravel!!!';
});
Route::get('/prueba', function ()
{
    return view('primera');
});
Route::get('/prueba2', function ()
{
    $nombre = 'marcos';
    $comidas = [
                'Carne al Horno con papas',
                'Milanesa a caballo',
                'Guiso de lentejas',
                'Lomito completo'
               ];
    $cantidad = count($comidas);
    return view('segunda',
                        [
                            'nombre'=>$nombre,
                            'comidas'=>$comidas,
                            'cantidad'=>$cantidad
                        ]
            );
});
