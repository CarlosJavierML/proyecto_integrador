<?php

namespace App\Http\Controllers;

use App\Models\Apartamento;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Catch_;
use PhpParser\Node\Stmt\TryCatch;
use Exception;
use Illuminate\Database\QueryException;
use App;
class AptoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apartamentos = \App\Models\Apartamento::paginate(5);
        $usuarios = Usuario::all();
        //mostrar una vista con los empleados
        return view('apartamento.list')->with("apartamentos", $apartamentos)->with("usuarios" , $usuarios);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usuarios = Usuario::all();
        return view('apartamento.create')->with("usuarios" , $usuarios);//->with("usuarios" , $data);
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
            'numeroApto' => 'required|max:3',
            'numeroTorre' => 'required|max:1',
            'estado' => 'required',
            'propietarioApartamento' => 'required',
        ]);

        if (isset($request->validate) && $request->validate->fails()) {
            return json_encode($validacion);
        }

        DB::beginTransaction();
        try {

            $apartamento = new Apartamento([
                'numeroApto' => $request->get('numeroApto'),
                'numeroTorre'=> $request->get('numeroTorre'),
                'estado' => $request->get('estado'),
                'idUsuario' => $request->get('propietarioApartamento'),
            ]);
            
            $apartamento->save();
            $idApto = $apartamento->id_apto;
            DB::commit();
            if ($idApto != NULL) {
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
     * @param  \App\Models\Apartamento  $apartamento
     * @return \Illuminate\Http\Response
     */
    public function show(Apartamento  $apartamento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Apartamento  $apartamento
     * @return \Illuminate\Http\Response
     */
    //public function edit(Apartamento $apartamento)
    public function edit(Apartamento $apartamento)
    {
        $apartamento = DB::table("apartamento as a")
            ->leftJoin("users as u", "a.idUsuario", "=", "u.id")
            ->where("a.id_apto", "=", $apartamento->id_apto)
            ->select("*", DB::raw("CONCAT(primerNombre, ' ', segundoNombre,' ', primerApellido, ' ', segundoApellido) as propietarioApartamento"))->get();
            return response()->json($apartamento);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Apartamento  $apartamento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Apartamento $apartamento)
    {
        $apartamento_id = $request->cid;
        $validacion = $request->validate([
            'numeroAptoNew' => 'required|max:3',
            'numeroTorreNew' => 'required|max:1',
            'estadoNew' => 'required',
            'proAptoNew' => 'required',
            
        ]);

        if (isset($request->validate) && $request->validate->fails()) {
            return json_encode($validacion);
        }

        DB::beginTransaction();
        try{
              
            $apartamento = Apartamento::find($apartamento_id);
            $apartamento->numeroApto= $request->input('numeroAptoNew');
            $apartamento->numeroTorre= $request->input('numeroTorreNew');
            $apartamento->estado= $request->input('estadoNew');
            $apartamento->idUsuario= $request->input('proAptoNew');
            $query = $apartamento->update();

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
     * @param  \App\Models\Apartamento $apartamento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apartamento $apartamento)
    {
        $apartamento->delete();
        return redirect('/apartamentos')->with('success', 'Apartamento deleted successfully');
    }
}
