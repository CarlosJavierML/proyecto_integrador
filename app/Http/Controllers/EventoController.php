<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Evento;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use Symfony\Component\HttpKernel\Event\ViewEvent;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('evento.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Evento::$rules);

        DB::table('eventos')->insert([
            'id_user' => Auth::user()->id,
            'title' => request()->input('title'),
            'descripcion' => request()->input('descripcion'),
            'start' => request()->input('start').' '.request()->input('startH'),
            'end' => request()->input('end').' '.request()->input('endH'),
            'estado' => request()->input('estado'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function show(Evento $evento)
    {
        if (Auth::user()->rol == 4) {
            $evento = DB::table('eventos')->where('id_user','=', Auth::user()->id)->get();
            
        } else {
            $evento = Evento::all();
            
        }
        
        foreach($evento as $event){
            $color = NULL;

            if ($event->estado == '1' ) {
                $color = '';
            } elseif ($event->estado == '2') {
                $color = '#378006';
            } elseif ($event->estado == '3') {
                $color = '#cf2118';
            }

            if (Auth::user()->rol == 4) {
                $solicitante = NULL;
                
            } else {
                $solicitante = $event->solicitante;
            }

            $eventos[] = [
                'id' => $event->id,
                'title' => $event->title,
                'descripcion' => $event->descripcion,
                'start' => $event->start,
                'end' => $event->end,
                'created_at' => $event->created_at,
                'updated_at' => $event->updated_at,
                'id_user' => $event->id_user,
                'estado' => $event->estado,
                'color' => $color,
                'solicitante' =>  $solicitante
                // 'solicitante' => $event->solicitante
            ];
            
        }

        return response()->json($eventos);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $evento = Evento::find($id);
        $evento =  DB::table('eventos as ev')
                        ->leftJoin('users as u', 'ev.id_user', '=', 'u.id')
                        ->select('ev.title', 'ev.descripcion', 'ev.id', 'ev.start', 'ev.end', 'ev.id_user', 'ev.estado', 'u.primerNombre', 'u.primerApellido', DB::raw('CONCAT(primerNombre, " ", primerApellido) as solicitante'))
                        ->where('ev.id', '=', $id)
                        ->get();

        // die($evento);
        $evento[0]->startF=Carbon::createFromFormat('Y-m-d H:i:s', $evento[0]->start)->format('Y-m-d');
        // die($evento[0]->startF);
        $evento[0]->endF=Carbon::createFromFormat('Y-m-d H:i:s', $evento[0]->end)->format('Y-m-d');
        
        $evento[0]->startH=Carbon::createFromFormat('Y-m-d H:i:s', $evento[0]->start)->format('H:i:s');
        $evento[0]->endH=Carbon::createFromFormat('Y-m-d H:i:s', $evento[0]->end)->format('H:i:s');

        return response()->json($evento[0]);
        //return $evento;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Evento $evento)
    {
        request()->validate(Evento::$rules);

        DB::table('eventos')
            ->where('id', request()->id)
            ->update([
            // 'id_user' => Auth::user()->id,
            'title' => request()->input('title'),
            'descripcion' => request()->input('descripcion'),
            'start' => request()->input('start').' '.request()->input('startH'),
            'end' => request()->input('end').' '.request()->input('endH'),
            'estado' => request()->input('estado'),
            
        ]);

        return response()->json($evento);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $evento = Evento::find($id)->delete();
        return response()->json($evento);
    }
}
