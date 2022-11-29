<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Crabbly\Fpdf\Fpdf;
use App\Empleado;
use App\Models\Visitante;
use Illuminate\Support\Facades\DB;

class PDFControllerVisitante extends Controller
{
    public function pdf()
    {

        ///////////////////
        $visi = DB::table('visita as v')
        ->leftJoin('visitante as vs', 'v.idVisitante', '=', 'vs.id_visi')
        ->leftJoin('apartamento as ap', 'v.idApto', '=', 'ap.id_apto')
        ->select('*');
        $visi = response()->json($visi);
        ///////////////////

        $tamañoceldas = 49;

        $pdf = app('Fpdf');

        //1. añadir paginas al documento
        $pdf->AddPage('P' , 'Legal');

        //2. Caracteristicas de estilo
        $pdf->SetFont('Times','', 18 );

        //3. Imprimir contenido en el pdf
        $pdf->Cell(1,10,'');
        $pdf->SetTextcolor(0, 0, 0);
        $pdf->Cell(80,9,'Reporte de Visitantes');
        $pdf->Image('../public/assets/img/Logo2.png',150,3,-450);
        $pdf->SetXY(10, 20);


        $pdf->SetFont('Times','B', 16 );
        $pdf->SetTextcolor(0, 0, 0);
        $pdf->Cell($tamañoceldas , 9 , "Id" , 'RTB' , 0, 'C');
        $pdf->SetFont('Times','', 16 );
        $pdf->Cell($tamañoceldas , 9 , "Nombre" , 'RTB' , 0, 'C');
        $pdf->Cell($tamañoceldas , 9 , "Telefono" , 'LTB' , 0, 'C');
        $pdf->Cell($tamañoceldas , 9 , "Estado" , 'LTB' , 1, 'C');

        $pdf->SetTextcolor(66, 18, 95 );

        foreach($visi as $visita){
            $pdf->SetFont('Times','B', 16 );
            $pdf->SetTextcolor(0, 0, 0);
            $pdf->Cell($tamañoceldas,10,$visita->id_regvisi,'LRTB',0 ,'C');
            $pdf->SetFont('Times','', 16 );
            $pdf->Cell($tamañoceldas,10,$visita->primerNombre,'LRTB',0 ,'C');
            $pdf->SetFont('Times','', 14 );
            $pdf->Cell($tamañoceldas,10,$visita->telefono,'LRTB',0 ,'C');
            $pdf->SetFont('Times','B', 14 );
            if($visita->idEstado===1){
                $pdf->SetTextcolor(11, 158, 24);
                $pdf->Cell($tamañoceldas,10,$visita->idEstado,'LRTB',1 ,'C');}
            else if ($visita->idEstado===2){
                $pdf->SetTextcolor(174, 14, 14);
                $pdf->Cell($tamañoceldas,10,$visita->idEstado,'LRTB',1 ,'C');
            }
        }


        //4. Mostrar el pdf
        return response($pdf->output() , 200 , [ 'Content-Type' => 'application/pdf' ]);

    }
}
