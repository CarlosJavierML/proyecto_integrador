<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Catch_;
use PhpParser\Node\Stmt\TryCatch;
use Exception;
use Illuminate\Database\QueryException;
use App;

class VehiculoController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehiculos = \App\Models\Vehiculo::paginate(5);
        $usuarios = Usuario::all();
        //mostrar una vista con los empleados
        //test 2
        return view('vehiculo.list')->with("vehiculos", $vehiculos)->with("usuarios" , $usuarios);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usuarios = Usuario::all();
      
        return view('vehiculo.create')->with("usuarios" , $usuarios);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validacion = $request->validate([
            'id_placa'=>'required',
            'tipo' => 'required',
            'marca' => 'required',
            'modelo' => 'required',
            'color' => 'required',
            'idUsuario' => 'required',
            'numParqueadero' => 'required',

        ]);

        if (isset($request->validate) && $request->validate->fails()) {
            return json_encode($validacion);
        }

        DB::beginTransaction();
        try {

            $vehiculo = new Vehiculo([
                'id_placa' => $request->get('id_placa'),
                'tipo' => $request->get('tipo'),
                'marca'=> $request->get('marca'),
                'modelo' => $request->get('modelo'),
                'color' => $request->get('color'),
                'idUsuario' => $request->get('idUsuario'),
                'numParqueadero' => $request->get('numParqueadero'),
            ]);
            
            $vehiculo->save();
            $id_placa = $vehiculo->id_placa;
            DB::commit();
            if ($id_placa != NULL) {
                return json_encode(['success' => '1']);
            }
        } 
        catch (\Exception $e) {
            DB::rollBack();
            $message = $e->getMessage();
            return json_encode(['error' => $message]);
        };
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vehiculo  $vehiculo
     * @return \Illuminate\Http\Response
     */
    public function show(Vehiculo $vehiculo)
    {
        $vehi = Vehiculo::where('id_placa',$vehiculo->id_placa)->get();

        // die($users);
        $html = "";
        if (!empty($vehi)) {
            $html = "
                <tr>
                    <th>Primer Nombre Residente:</th>
                    <td>" . $vehi[0]['numeroApto'] . "</td>
                </tr>
                <tr>
                    <th>Segundo Nombre Residente:</th>
                    <td>" . $vehi[0]['numeroTorre'] . "</td>
                </tr>
                <tr>
                    <th>Primer Apellido Residente:</th>
                    <td>" . $vehi[0]['estado'] . "</td>
                </tr>
                <tr>
                    <th>Segundo Apellido Residente:</th>
                    <td>" . $vehi[0]['idUsuario'] . "</td>
                </tr>            
           ";
        }
        $response['html'] = $html;

        return response()->json($response);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vehiculo  $vehiculo
     * @return \Illuminate\Http\Response
     */
    public function edit(Vehiculo $vehiculo)
    {
        //$usuarios = Usuario::all();
        $vehiculo = DB::table('vehiculo as v')
            ->leftJoin('users as u', 'v.idUsuario', '=', 'u.id')
            ->where('v.id_placa', '=', $vehiculo->id_placa)
            ->select('*')->get();
            return response()->json($vehiculo);

       /* $usuario = DB::table('usuario as u')
            ->leftJoin('rol as r', 'u.idRol', '=', 'r.id_rol')
            ->leftJoin('estado as e', 'u.idEstado', '=', 'e.id_est')
            ->where('u.id_usu', '=', $usuario->id_usu)
            ->select('*')->get();

            
            return response()->json($usuario);*/
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vehiculo  $vehiculo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vehiculo $vehiculo)
    {
        $vehiculo_id = $request->cid;
        $validacion = $request->validate([
            //'tipoNew' => 'required',
            //'marcaNew' => 'required',
            //'modeloNew' => 'required',
            'colorNew' => 'required',
            'idUsuarioNew' => 'required',
            'numParqueaderoNew' => 'required',
            
        ]);

        if (isset($request->validate) && $request->validate->fails()) {
            return json_encode($validacion);
        }

        DB::beginTransaction();
        try{
              
            $vehiculo = Vehiculo::find($vehiculo_id);
           // $vehiculo->tipo= $request->input('tipoNew');
            //$vehiculo->marca= $request->input('marcaNew');
            //$vehiculo->modelo= $request->input('modeloNew');
            $vehiculo->color= $request->input('colorNew');
            $vehiculo->idUsuario= $request->input('idUsuarioNew');
            $vehiculo->numParqueadero= $request->input('numParqueaderoNew');
            $query = $vehiculo->update();

            DB::commit();
            if($query){
                return json_encode(['success'=>1]);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            $message = $e->getMessage();
            return json_encode(['error'=>$message]);
        };
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vehiculo  $vehiculo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vehiculo $vehiculo)
    {
        $vehiculo->delete();
        return redirect('/vehiculos')->with('success', 'vehiculo deleted successfully');
    
    }
}
