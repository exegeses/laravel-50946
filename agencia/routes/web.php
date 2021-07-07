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

###########################################
#### CRUD de regiones
Route::get('/adminRegiones', function ()
{
    //obtenemos listado de regiones
    /* raw SQL
    $regiones = DB::select('SELECT regID, regNombre FROM regiones');
    */
    $regiones = DB::table('regiones')->get();
    //retornamos vista con datos
    return view('adminRegiones', [ 'regiones' => $regiones ]);
});
Route::get('/agregarRegion', function ()
{
    return view('agregarRegion');
});
Route::post('/agregarRegion', function ()
{
    //capturamos dato enviado por el form
    $regNombre = $_POST['regNombre'];
    //guardamos en tabla regiones
    /* raw SQL
    DB::insert('INSERT INTO regiones


                                    ( regNombre )
                                VALUE
                                    ( :regNombre )',
                        [ $regNombre ]
                );
    */
    DB::table('regiones')->insert([ 'regNombre'=>$regNombre ]);
    //retornamos redirección con mensaje ok
    return redirect('/adminRegiones')
                ->with([ 'mensaje'=>'Región: '.$regNombre.' agregada correctamente' ]);
});
Route::get('/modificarRegion/{id}', function ($id)
{
    //obtenemos datos de una region por su ID
    $region = DB::select('SELECT regID, regNombre
                             FROM regiones
                            WHERE regID = :id',
                            [ $id ]
                );
    //retornamos vista del form con datos
    return view('modificarRegion', [ 'region'=>$region ]);
});
Route::put('/modificarRegion', function ()
{
    //capturamos dato enviado por el form
    $regNombre = $_POST['regNombre'];
    $regID = $_POST['regID'];
    //modificar en tabla regiones
    /*
    DB::update('UPDATE regiones
                    SET
                        regNombre = :regNombre
                  WHERE regID = :regID',
                    [ $regNombre, $regID ]
        );
    */
    DB::table('regiones')
            ->where('regID', $regID)
            ->update( [ 'regNombre'=>$regNombre ] );
    //retornamos redirección con mensaje ok
    return redirect('/adminRegiones')
        ->with([ 'mensaje'=>'Región: '.$regNombre.' modificada correctamente' ]);
});
Route::get('/eliminarRegion/{id}', function($id)
{
    //obtenomos una region por su id
    /*
    $region = DB::select('SELECT regID, regNombre
                            FROM regiones
                            WHERE regID = :id', [$id]
                    );
    */
    $region = DB::table('regiones')
                    ->where('regID', $id)
                    ->first();
    return view('eliminarRegion', [ 'region'=>$region ]);
});
