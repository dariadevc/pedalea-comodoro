<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ManualController extends Controller
{
    public function descargarManual($archivo)
    {
        $usuario = Auth::user();

        $nombre_archivo = null;

        // Verificar el rol del usuario y asignar el archivo correspondiente
        if ($archivo === 'manual_cliente' && $usuario->hasRole('cliente')) {
            $nombre_archivo = 'Manual_Usuario_Cliente-Pedalea_Comodoro.pdf';
        } elseif ($archivo === 'manual_administrativo' && $usuario->hasRole('administrativo')) {
            $nombre_archivo = 'Manual_Usuario_Administrador-Pedalea_Comodoro.pdf';
        } elseif ($archivo === 'manual_inspector' && $usuario->hasRole('inspector')) {
            $nombre_archivo = 'Manual_Usuario_Inspector-Pedalea_Comodoro.pdf';
        } else {
            // Si el rol no coincide con el manual solicitado, redirigir con mensaje de error
            return redirect()->route('inicio')->with('error', 'No tienes acceso al manual solicitado');
        }

        // Verificar si el archivo existe
        $rutaArchivo = public_path('manuales/' . $nombre_archivo);

        if (file_exists($rutaArchivo)) {
            return Response::file($rutaArchivo, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $nombre_archivo . '"'
            ]);
        }

        return redirect()->route('inicio')->with('error', 'Manual no encontrado');
    }
}
