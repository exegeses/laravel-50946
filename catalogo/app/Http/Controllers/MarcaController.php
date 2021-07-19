<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Producto;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //obtenemos listado de marcas
        //$marcas = DB::select(....);
        //$marcas = DB::table('ntable')->get();
        //$marcas = Marca::all();
        $marcas = Marca::paginate(7);
        //retornamos vista pasando datos
        return view('adminMarcas', [ 'marcas'=>$marcas ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('agregarMarca');
    }

    /**
     * @param Request $request
     */
    private function validarForm(Request $request): void
    {
        $request->validate(
            ['mkNombre' => 'required|min:2|max:50'],
            [
                'mkNombre.required' => 'El campo "Nombre de la marca" es obligatorio.',
                'mkNombre.min' => 'El campo "Nombre de la marca" debe contener al menos 2 caractéres.',
                'mkNombre.max' => 'El campo "Nombre de la marca" debe contener 50 caractéres como máximo.'
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //captura dato enviado por el form
        #$mkNombre = $_POST['mkNombre'];
        $mkNombre = $request->mkNombre;
        //validación
        $this->validarForm($request);
        //instanciación, asignación y gaurdado
        $Marca = new Marca;
        $Marca->mkNombre = $mkNombre;
        $Marca->save();
        //redirección con mensaje ok
        return redirect('/adminMarcas')
                    ->with(
                        [
                            'mensaje'=>'Marca: '.$mkNombre. ' agregada correctamente.',
                            'css' => 'success'
                        ]
                    );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //obtenemos datos de una marca
        $Marca = Marca::find($id);
        //retornamos vista con datos
        return view('modificarMarca', [ 'Marca'=>$Marca ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $mkNombre = $request->mkNombre;
        //validacion
        $this->validarForm($request);
        //obtenemos datos de la marca
        $Marca = Marca::find($request->idMarca);
        //modificamos atributo
        $Marca->mkNombre = $mkNombre;
        //guardamos en bbdd
        $Marca->save();
        //redirección con mensaje ok
        return redirect('/adminMarcas')
            ->with(
                [
                    'mensaje'=>'Marca: '.$mkNombre. ' modificada correctamente.',
                    'css' => 'success'
                ]
            );
    }

    private function productoPorMarca($idMarca)
    {
        //$check = Producto::where('idMarca', $idMarca)->first();
        //$check = Producto::firstWhere('idMarca', $idMarca);
        $check = Producto::where('idMarca', $idMarca)->count();
        return $check;
    }

    public function confirmarBaja($id)
    {
        //obtenemos datos de una marca
        $Marca = Marca::find($id);
        ## chequear si NO hay productos de esa marca
        if( $this->productoPorMarca($id) == 0 ){
            //retornar vista para confirmar
            return view('eliminarMarca', [ 'Marca'=>$Marca ]);
        }
        ##redirigir a admin con mensaje que no se puede eliminar
        return redirect('/adminMarcas')
                    ->with(
                        [
                            'mensaje'=>'No se puede eliminar la marca: '.$Marca->mkNombre.' porque tiene productos asociados.',
                            'css' => 'warning'
                        ]
                    );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Marca::destroy($request->idMarca);
        return redirect('/adminMarcas')
                    ->with(
                        [
                            'mensaje'=>'Marca: '.$request->mkNombre.' eliminada correctamente.',
                            'css' => 'success'
                        ]
                    );
    }

}
