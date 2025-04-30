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
        // Obtener el correo electrónico del encabezado
        $userEmail = $request->header('email');

        // Validar que el correo y el archivo estén presentes
        if (!$userEmail || !$request->hasFile('reporte')) {
            return response()->json(['error' => 'El encabezado de correo electrónico o el archivo PDF faltan.'], 400);
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
}
