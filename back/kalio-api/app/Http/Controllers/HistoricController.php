<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Dompdf\Dompdf;
use Dompdf\Options;
use Imagick;

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
        $request->validate([
            'image' => 'required|file|mimes:png,jpg,jpeg',
        ]);

        try {
            // Obtener el archivo de la solicitud
            $image = $request->file('image');

            // Procesar la imagen con Imagick para manejar la transparencia
            $imagick = new Imagick($image->getPathname());
            if ($imagick->getImageAlphaChannel()) {
                // Si la imagen tiene canal alfa, elimina la transparencia
                $imagick->setImageBackgroundColor('white');
                $imagick = $imagick->mergeImageLayers(Imagick::LAYERMETHOD_FLATTEN);
            }

            // Guardar la imagen procesada como archivo temporal
            $imagePath = storage_path('app/public/temp_image_' . time() . '.png');
            $imagick->writeImage($imagePath);

            // Crear el contenido HTML para el PDF
            $html = '
                <html>
                    <head>
                        <style>
                            body { font-family: Arial, sans-serif; text-align: center; }
                            img { max-width: 100%; height: auto; }
                        </style>
                    </head>
                    <body>
                        <h1>Gráfico Generado</h1>
                        <img src="' . asset('storage/img/' . basename($imagePath)) . '" alt="Gráfico">
                    </body>
                </html>
            ';

            // Configurar DomPDF
            $options = new Options();
            $options->set('isRemoteEnabled', true); // Permitir cargar imágenes remotas
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait'); // Configurar tamaño y orientación del papel
            $dompdf->render();

            // Guardar el PDF como archivo temporal
            $pdfPath = storage_path('app/public/temp_pdf_' . time() . '.pdf');
            file_put_contents($pdfPath, $dompdf->output());

            // Eliminar la imagen temporal
            unlink($imagePath);

            // Devolver el PDF generado como respuesta
            return response()->download($pdfPath)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al convertir la imagen a PDF: ' . $e->getMessage()
            ], 500);
        }
    }
}
