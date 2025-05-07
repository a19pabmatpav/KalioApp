<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HistoricController extends Controller
{
    public function sendHistoric(Request $request)
    {
        // Obtener el usuario autenticado a partir del token
        $user = $request->user(); // Esto funciona si estás usando auth:sanctum o auth:api

        // Verificar que el usuario esté autenticado
        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado.'], 401);
        }

        // Obtener el correo electrónico del usuario autenticado
        $userEmail = $user->email;

        // Validar que el archivo esté presente
        if (!$request->hasFile('reporte')) {
            return response()->json(['error' => 'El archivo PDF falta.'], 400);
        }

        // Validar que el archivo sea un PDF
        $pdfFile = $request->file('reporte');
        if ($pdfFile->getClientOriginalExtension() !== 'pdf') {
            return response()->json(['error' => 'El archivo debe ser un PDF.'], 400);
        }

        // Guardar temporalmente el archivo recibido
        $tempPath = storage_path('app/temp_' . Str::random(10) . '.pdf');
        try {
            $pdfFile->move(dirname($tempPath), basename($tempPath));
        } catch (\Exception $e) {
            return response()->json(['error' => 'No se pudo guardar el archivo temporal: ' . $e->getMessage()], 500);
        }

        // Enviar el correo con el PDF adjunto
        try {
            Mail::send([], [], function ($message) use ($userEmail, $tempPath) {
                $message->to($userEmail)
                    ->subject('Histórico generado')
                    ->from(config('mail.from.address'), config('mail.from.name'))
                    ->setBody('Adjunto encontrarás tu histórico en formato PDF.')
                    ->attach($tempPath, [
                        'as' => 'historico.pdf',
                        'mime' => 'application/pdf',
                    ]);
            });

            // Eliminar el archivo temporal después de enviar el correo
            unlink($tempPath);

            return response()->json(['message' => 'Correo enviado con el PDF adjunto.']);
        } catch (\Exception $e) {
            // Eliminar el archivo temporal en caso de error
            if (file_exists($tempPath)) {
                unlink($tempPath);
            }
            return response()->json(['error' => 'No se pudo enviar el correo: ' . $e->getMessage()], 500);
        }
    }

    public function imgToPdf(Request $request)
    {
        // Validar que el archivo esté presente y sea una imagen
        // $request->validate([
        //     'image' => 'required|file|mimes:png,jpg,jpeg',
        // ]);


        try {
            // Obtener el archivo de la solicitud
            $image = $request->file('image');

            // Guardar la imagen como archivo temporal
            $imagePath = $image->storeAs('temp', 'chart_' . time() . '.' . $image->getClientOriginalExtension(), 'public');

            // Crear un PDF con TCPDF
            $pdf = new \TCPDF();
            $pdf->AddPage();
            $pdf->Image(storage_path('app/public/' . $imagePath), 10, 10, 180); // 180 = ancho; se ajusta automáticamente el alto
            return response()->json([
                'message' => 'Validación de imagen omitida para pruebas.'
            ], 200);
            // Guardar el PDF como archivo temporal
            $pdfPath = storage_path('app/public/temp_pdf_' . time() . '.pdf');
            $pdf->Output($pdfPath, 'F');

            // Eliminar la imagen temporal
            unlink(storage_path('app/public/' . $imagePath));

            // Devolver el PDF generado como respuesta
            return response()->download($pdfPath)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al convertir la imagen a PDF: ' . $e->getMessage()
            ], 500);
        }
    }
}
