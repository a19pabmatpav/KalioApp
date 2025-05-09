<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// Route::get('/test-pdf', function () {
//     $pdf = new \TCPDF();
//     $pdf->AddPage();
//     $pdf->Image(public_path('img/example.png'), 15, 10, 50, 50, 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);
//     $pdf->Write(0, 'Hola mundo en PDF');
//     return $pdf->Output('test.pdf', 'I');
// });

