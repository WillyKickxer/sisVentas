<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;

use sisVentas\Http\Requests;

class PDFController extends Controller
{
    public function PDF(){
        $pdf = \PDF::loadView('reports/reporte');
        return $pdf->stream('prueba.pdf'); //stream:previsualiza el archivo download:descarga el archivo
    }
}
