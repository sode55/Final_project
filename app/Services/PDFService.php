<?php

namespace App\Services;

use Barryvdh\DomPDF\PDF;

class PDFService
{
    public function generate()
    {
        $pdf = PDF::loadView('pdf.pdf');
        $path = public_path('pdf/');
        $fileName =  time().'.'. 'pdf' ;
        $pdf->save($path . '/' . $fileName);
        $pdf = public_path('pdf/'.$fileName);

        return $pdf;
    }
}
