<?php

namespace App\Models;

use App\Mail\MailTextoSimple;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Multa extends Model
{
    use HasFactory;

    protected $table = 'multas';
    protected $primaryKey = 'id_multa';
    public $timestamps = false;

    //Son modificables:
    protected $fillable = [
        'id_usuario',
        'id_estado',
        'monto',
        'fecha_hora',
        'descripcion',
    ];

    //No modificables:
    protected $guarded = [
        'id_multa',
    ];


    public static function crearMulta($id_usuario, $monto)
    {
        $multa = new Self();
        $multa->id_usuario = $id_usuario;
        $multa->monto = $monto;
        $multa->fecha_hora = Carbon::now();


        $multa->cambiarEstado('Pendiente');

        return $multa;
    }

    public function generarDescripcion($puntaje)
    {
        $this->descripcion = "Multa generada por puntaje negativo acumulado: {$puntaje}";
    }

    public function cambiarEstado($nombre_estado)
    {
        $estado = EstadoMulta::where('nombre', $nombre_estado)->first();
        $this->id_estado = $estado->id_estado;
    }

    public function guardarMultaCreada()
    {
        $mensaje = $this->getDetallesMulta();
        $asunto = "Multa realizada";
        $destinatario = $this->cliente->usuario->email;

        /**
         * $mensaje, $asunto HAY QUE FIJARSE QUE PONEMOS
         * ------
         * NO OLVIDARSE DE DESCOMENTAR LA LINEA DEL MAIL PARA QUE SE MANDE 
         */

        Mail::to($destinatario)->send(new MailTextoSimple($mensaje, $asunto));
        $this->save();
    }
    public function getDetallesMulta()
    {
        $mensaje = "Estimado/a {$this->cliente->usuario->nombre},\n\n" .
            "Esperamos que te encuentres bien. Queremos informarte que se ha generado una multa en tu cuenta debido a un puntaje acumulado negativo.\n\n" .
            "Detalles de la Multa:\n" .
            "- Razón: Puntaje negativo acumulado.\n" .
            "- Puntaje Actual: {$this->cliente->puntaje} puntos.\n" .
            "- Monto de la Multa: \${$this->monto}.\n\n" .
            "Saludos cordiales,\n" .
            "[Pedalea Comodoro]\n";

        return $mensaje;
    }

    //Una multa tiene un estado de multa:
    public function estado()
    {
        return $this->belongsTo(EstadoMulta::class, 'id_estado', 'id_estado');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_usuario', 'id_usuario');
    }
}
