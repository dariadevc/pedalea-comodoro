<?php

namespace App\Models;

use App\Mail\MailTextoSimple;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Mail;

class Suspension extends Model
{
    use HasFactory;
    
    protected $table = 'suspensiones';
    protected $primaryKey = 'id_suspension';
    public $timestamps = false;

    // Los atributos que pueden modificarse
    protected $fillable = [
        'id_usuario',
        'id_estado',
        'fecha_desde',
        'fecha_hasta',
        'fecha_hora',
        'descripcion',
    ];

    // Los atributos que no pueden modificarse
    protected $guarded = [
        'id_suspension',
    ];

    public static function crearSuspension($id_usuario, $tiempo_suspension_dias)
    {
        $suspension = new Suspension();
        $suspension->id_usuario = $id_usuario;
        $suspension->fecha_desde = Carbon::now();
        $suspension->fecha_hasta = Carbon::now()->addDays($tiempo_suspension_dias);
        $suspension->fecha_hora = Carbon::now();

        $suspension->cambiarEstado('Activa');

        return $suspension;
    }

    public function cambiarEstado($nombre_estado)
    {
        $estado = EstadoSuspension::where('nombre', $nombre_estado)->first();
        $this->id_estado = $estado->id_estado;
    }

    public function generarDescripcion($puntaje)
    {
        $this->descripcion = "Suspension generada por puntaje negativo acumulado: {$puntaje}";
    }

    public function getDetallesSuspension()
    {

        $tiempo_suspension_dias = (int) ($this->fecha_desde->diffInDays($this->fecha_hasta));


        $mensaje = "Estimado/a {$this->cliente->usuario->nombre},\n\n" .
            "Esperamos que te encuentres bien. Queremos informarte que se ha generado una suspensión en tu cuenta debido a un puntaje acumulado negativo.\n\n" .
            "Detalles de la suspensión:\n" .
            "- Razón: Puntaje negativo acumulado.\n" .
            "- Puntaje Actual: {$this->cliente->puntaje} puntos.\n" .
            "- Tiempo de suspensión: {$tiempo_suspension_dias} días.\n\n" .
            "- Fechas: Desde {$this->fecha_desde->format('Y-m-d')} hasta {$this->fecha_hasta->format('Y-m-d')}.\n\n" .
            "Saludos cordiales,\n" .
            "[Pedalea Comodoro]\n";

        return $mensaje;
    }

    public function guardarSuspensionCreada()
    {
        $mensaje = $this->getDetallesSuspension();
        $asunto = "Suspensión realizada";
        $destinatario = $this->cliente->usuario->email;

        /**
         * $mensaje, $asunto HAY QUE FIJARSE QUE PONEMOS
         * ------
         * NO OLVIDARSE DE DESCOMENTAR LA LINEA DEL MAIL PARA QUE SE MANDE 
         */
        $this->cliente->cambiarEstado('Suspendido');
        Mail::to($destinatario)->send(new MailTextoSimple($mensaje, $asunto));
        
        $this->save();
    }


    // Relación con el estado
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_usuario', 'id_usuario');
    }
    public function estadoSuspension()
    {
        return $this->belongsTo(EstadoSuspension::class, 'id_estado', 'id_estado');
    }
}
