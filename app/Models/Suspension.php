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

    /**
     * Crea una nueva suspensión para un cliente.
     *
     * @param int $id_usuario_cliente
     * @param int $tiempo_suspension_dias
     * @return Suspension
     */
    public static function crearSuspension(int $id_usuario_cliente, int $tiempo_suspension_dias): Suspension
    {
        $suspension = new Suspension();
        $suspension->id_usuario = $id_usuario_cliente;
        $suspension->fecha_desde = Carbon::now();
        $suspension->fecha_hasta = Carbon::now()->addDays($tiempo_suspension_dias);
        $suspension->fecha_hora = Carbon::now();

        $suspension->cambiarEstado(EstadoSuspension::ACTIVA);

        return $suspension;
    }

    /**
     * Cambia el estado de la suspensión según el ID proporcionado.
     *
     * @param int $id_estado ID del estado
     * @return void
     */
    public function cambiarEstado(int $id_estado): void
    {
        $this->id_estado = $id_estado;
    }

    /**
     * Genera la descripción de la suspensión en base al puntaje.
     *
     * @param int $puntaje Puntaje asociado a la suspensión
     * @return void
     */
    public function generarDescripcion(int $puntaje): void
    {
        $this->descripcion = "Suspension generada por puntaje negativo acumulado: {$puntaje}";
    }

    /**
     * Obtiene los detalles de la suspensión como un mensaje.
     *
     * @return string
     */
    public function getDetallesSuspension(): string
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

    /**
     * Guarda la suspensión creada y envía una notificación por correo electrónico.
     *
     * @return void
     */
    public function guardarSuspensionCreada(): void
    {
        $mensaje = $this->getDetallesSuspension();
        $asunto = "Suspensión realizada";
        $destinatario = $this->cliente->usuario->email;

        /**
         * $mensaje, $asunto HAY QUE FIJARSE QUE PONEMOS
         * ------
         * NO OLVIDARSE DE DESCOMENTAR LA LINEA DEL MAIL PARA QUE SE MANDE 
         */
        $this->cliente->cambiarEstado(EstadoCliente::SUSPENDIDO);
        Mail::to($destinatario)->send(new MailTextoSimple($mensaje, $asunto));
        
        $this->save();
    }

    // Relaciones

    /**
     * Relación con el cliente asociado a la suspensión.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cliente(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Relación con el estado de la suspensión.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estadoSuspension(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(EstadoSuspension::class, 'id_estado', 'id_estado');
    }
}
