<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ManualController extends Controller
{
    public function descargarManual()
    {
        $usuario = Auth::user();
        $archivo = null;

        switch ($archivo) {
            case 'manual_cliente':
                if ($usuario->hasRole('cliente')) {
                    $nombre_archivo = 'Manual_Usuario_Cliente-Pedalea_Comodoro.pdf';
                }
                break;

            case 'manual_administrativo':
                if ($usuario->hasRole('administrativo')) {
                    $nombre_archivo = 'Manual_Usuario_Administrador-Pedalea_Comodoro.pdf';
                }
                break;

            case 'manual_inspector':
                if ($usuario->hasRole('inspector')) {
                    $nombre_archivo = 'Manual_Usuario_Inspector-Pedalea_Comodoro.pdf';
                }
                break;

            default:
                return redirect()->route('inicio')->with('error', 'No tienes acceso al manual');
        }

        // Verificar si el archivo existe
        $rutaArchivo = public_path('manuales/' . $nombre_archivo);

        if (file_exists($rutaArchivo)) {
            // Descargar el archivo con el nombre adecuado
            return Response::download($rutaArchivo, $nombre_archivo);
        }

        return redirect()->route('inicio')->with('error', 'Manual no encontrado');
    }
}
