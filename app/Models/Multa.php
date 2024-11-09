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

    // Son modificables:
    protected $fillable = [
        'id_usuario',
        'id_estado',
        'monto',
        'fecha_hora',
        'descripcion',
    ];

    /**
     * Crea una nueva multa para un usuario.
     *
     * @param int $id_usuario ID del usuario asociado a la multa
     * @param float $monto Monto de la multa
     * @return Multa
     */
    public static function crearMulta(int $id_usuario, float $monto): Multa
    {
        $multa = new Self();
        $multa->id_usuario = $id_usuario;
        $multa->monto = $monto;
        $multa->fecha_hora = Carbon::now();

        $multa->cambiarEstado(EstadoMulta::PENDIENTE);

        return $multa;
    }

    /**
     * Genera una descripción de la multa basada en el puntaje.
     *
     * @param int $puntaje Puntaje asociado a la multa
     * @return void
     */
    public function generarDescripcion(int $puntaje): void
    {
        $this->descripcion = "Multa generada por puntaje negativo acumulado: {$puntaje}";
    }

    /**
     * Cambia el estado de la multa.
     *
     * @param int $id_estado
     * @return void
     */
    public function cambiarEstado(int $id_estado): void
    {
        $this->id_estado = $id_estado;
    }

    /**
     * Guarda la multa creada y envía una notificación por correo electrónico.
     *
     * @return void
     */
    public function guardarMultaCreada(): void
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

    /**
     * Obtiene los detalles del mensaje de la multa.
     *
     * @return string
     */
    public function getDetallesMulta(): string
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

    /**
     * Devuelve el estado asociado a la multa.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estado(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(EstadoMulta::class, 'id_estado', 'id_estado');
    }

    /**
     * Devuelve el cliente asociado a la multa.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cliente(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'id_usuario', 'id_usuario');
    }
}
