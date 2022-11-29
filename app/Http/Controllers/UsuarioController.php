<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Usuario;
use App\Models\Estado;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response FK_Usuario_idRolFK
     */
    public function index(Usuario $usuario)
    {
        //Consulta de la tabla 
        // $usuarios = DB::table('estado as e')
        //     ->leftJoin('usuario as u', 'e.id_est', '=', 'u.idEstado')
        //     ->select('*')->get();


        $usuarios = \App\Models\Usuario::paginate(5);
        $roles = Rol::all();
        $estados = Estado::all();
        //mostrar una vista con los empleados
        //test 2
        return view('usuario.list')->with("usuarios", $usuarios)->with("roles", $roles)->with("estados", $estados);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(\App\Http\Requests\UserStoreRequest $request)
    {

        $estados = Estado::all();
        $roles = Rol::all();

        return view('usuario.create')->with("roles", $roles)->with("estados", $estados);
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
            'primerNombre' => 'required',
            'primerApellido' => 'required',
            'tipoDoc' => 'required',
            'numeroIdentidad' => 'required',
            'fechaNacimiento' => 'required',
            'sexo' => 'required',
            'celular' => 'required',
            'correo' => 'required',
            'estado' => 'required',
            'rol' => 'required',

            'password' => [
                'required',
                'max:50',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
            "password_confirmation" => "required|min:8|max:50|same:password",
        ]);

        

        if (isset($request->validate) && $request->validate->fails()) {
            return json_encode($validacion);
        }

        DB::beginTransaction();
        try {
            $usuario = new Usuario([
                'primerNombre' => $request->get('primerNombre'),
                'primerApellido' => $request->get('primerApellido'),
                'name' => $request->get('primerNombre').' '.$request->get('primerApellido'),
                'tipoDoc' => $request->get('tipoDoc'),
                'numeroDoc' => $request->get('numeroIdentidad'),
                'fechaNacimiento' => $request->get('fechaNacimiento'),
                'sexo' => $request->get('sexo'),
                'telefono' => $request->get('celular'),
                'correo' => $request->get('correo'),
                'email' => $request->get('correo'),
                'idEstado' => $request->get('estado'),
                'idRol' => $request->get('rol'),
                'rol' => $request->get('rol'),
                'password' => bcrypt($request->get('password'))
            ]);

            $usuario->save();
            $idusu = $usuario->id;
            DB::commit();
            if ($idusu != NULL) {
                return json_encode(['success' => '1']);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $message = $e->getMessage();
            return json_encode(['error' => $message]);
        };
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function show(Usuario $usuario)
    {
        // die(var_dump($usuario->id_usu));
        // $users = Usuario::find($usuario->id_usu)->first();
        $users = Usuario::where('id',$usuario->id)->get();

        // die($users);
        $html = "";
        if (!empty($users)) {
            $html = "
                <tr>
                    <th>Primer Nombre Residente:</th>
                    <td>" . $users[0]['primerNombre'] . "</td>
                </tr>
                <tr>
                    <th>Segundo Nombre Residente:</th>
                    <td>" . $users[0]['segundoNombre'] . "</td>
                </tr>
                <tr>
                    <th>Primer Apellido Residente:</th>
                    <td>" . $users[0]['primerApellido'] . "</td>
                </tr>
                <tr>
                    <th>Segundo Apellido Residente:</th>
                    <td>" . $users[0]['segundoApellido'] . "</td>
                </tr>
                <tr>
                    <th>Tipo Documento:</th>
                    <td>" . $users[0]['tipoDoc'] . "</td>
                </tr>
                <tr>
                    <th>Número Documento:</th>
                    <td>" . $users[0]['numeroDoc'] . "</td>
                </tr>
                <tr>
                    <th>Fecha Nacimiento:</th>
                    <td>" . $users[0]['fechaNacimiento'] . "</td>
                </tr>
                <tr>
                    <th>Sexo:</th>
                    <td>" . $users[0]['sexo'] . "</td>
                </tr>
                <tr>
                    <th>Celular:</th>
                    <td>" . $users[0]['telefono'] . "</td>
                </tr>
                <tr>
                    <th>Correo:</th>
                    <td>" . $users[0]['email'] . "</td>
                </tr>
            
           ";
        }
        $response['html'] = $html;

        return response()->json($response);
        // return view('usuario.view', compact('usuario'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function edit(Usuario $usuario)
    {
        //$usuario = Usuario::findOrFail($id_usu);
        $usuario = DB::table('users as u')
            ->leftJoin('rol as r', 'u.idRol', '=', 'r.id_rol')
            ->leftJoin('estado as e', 'u.idEstado', '=', 'e.id_est')
            ->where('u.id', '=', $usuario->id)
            ->select('*')->get();

            //dd($usuario);
            return response()->json($usuario);
        //return view('usuario.edit')->with("usuario", $usuario);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Usuario $usuario)
    {
    
        $usuario_id = $request->cid;
        
        $validacion = $request->validate([
            'primNomUpdate' => 'required',
            'priApeUpdate' => 'required',
            'telUpdate' => 'required',
            'emailUpdate' => 'required',
            'estadoUpdate' => 'required'
        ]);

        if (isset($request->validate) && $request->validate->fails()) {
            return json_encode($validacion);
        }

        DB::beginTransaction();
        try{
  
            $usuario = Usuario::find($usuario_id);
            $usuario->primerNombre = $request->input("primNomUpdate");
            $usuario->segundoNombre = $request->input("segNomUpdate");
            $usuario->primerApellido = $request->input("priApeUpdate");
            $usuario->segundoApellido = $request->input("segApeUpdate");
            $usuario->telefono = $request->input("telUpdate");
            $usuario->email = $request->input("emailUpdate");
            $usuario->idEstado = $request->input("estadoUpdate");
            $query = $usuario->update();
            
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
     * @param  int $id_usu
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Usuario::destroy($id);
        return redirect('/usuarios')->with('destroy', 'Datos eliminados');
        //echo $id_usu;
    }

    public function habilitar($id){
        $usuario = Usuario::find($id);
        switch($usuario->idEstado){
            case null:
                $usuario->idEstado=1;
                $usuario->save();
                $mensaje_exito = 'Residente Habilitado';
                break;
            case 1:
                $usuario->idEstado=2;
                $usuario->save();
                $mensaje_exito = 'Residente Deshabilitado';

                break;

            case 2:
                $usuario->idEstado=1;
                $usuario->save();
                $mensaje_exito = 'Usuario Activado';
                break;
        }
        return redirect('usuarios')->with('mensaje_exito', $mensaje_exito);
    }
}