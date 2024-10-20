<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Reserva;

class Estacion extends Model
{
    use HasFactory;

    protected $table = 'estaciones';
    protected $primaryKey = 'id_estacion';
    public $timestamps = false;

    // Los atributos que pueden modificarse
    protected $fillable = [
        'id_estado',
        'nombre',
        'latitud',
        'longitud',
        'calificacion', //Se calcula cada vez que se agrega una calificación
    ];

    // Los atributos que no pueden modificarse
    protected $guarded = [
        'id_estacion',
    ];

    // Relación con el estado
    public function estado()
    {
        return $this->belongsTo(EstadoEstacion::class, 'id_estado'); //Acá va la clave foránea
    }


    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class, 'id_estacion', 'id_estacion');
    }

    public function bicicletas()
    {
        return $this->hasMany(Bicicleta::class, 'id_estacion_actual', 'id_estacion');
    }

    public function reservaRetiro()
    {
        return $this->hasMany(Reserva::class, 'id_estacion_retiro', 'id_estacion');
    }

    public function reservaDevolucion()
    {
        return $this->hasMany(Reserva::class, 'id_estacion_devolucion', 'id_estacion');
    }


    public function actualizarPromedio()
    {
        // Calcular el promedio de todas las calificaciones de esta estación
        $promedio = $this->calificaciones()  // Usar la relación ya existente
            ->join('tipos_calificacion', 'calificaciones.id_tipo_calificacion', '=', 'tipos_calificacion.id_tipo_calificacion')
            ->avg('tipos_calificacion.cantidad_estrellas');

        // Actualizar la calificación promedio de la estación
        $this->calificacion = $promedio ?? 0;
        $this->save();
    }

    /* Se supone que el horario_retiro que ha ingresado el usuario, es uno tal que es hasta
    dos horas de antelación, por lo que este metodo trabaja sobre un horario de retiro ya valido previamente!    
    */

    /*Una bicicleta está disponible (es decir, no está reservada ni alquilada ni fuera
    de servicio) en una estación, si en mi colección de reservas
    está disponible exactamente en el horario de retiro. ¿Qué pasa con las reservas que
    no han sido confirmadas aún ?(no estan alquiladas) ¿no están disponibles en todo el día
    (es decir, hasta que estén disponibles nuevamente), hasta que sean devueltas 
    o que no hayan ido a alquilarlas (y entonces el sistema las cambia a estado disponible
    automaticamente) ? sí. exactamente. 
    No hay rangos a tener en cuenta, o está disponible en el horario de retiro que 
    quiere el cliente, o no lo está. Nada más.
        
    Una bicicleta solo dejará de estar reservada, si el cliente hace la devolución,
    si un cliente indica que la bicicleta está disponible físicamente en el momento 
    de la devolución (aún cuando a nivel sistema no lo estaba. Esto sucede cuando alguien
    la devuelve pero no confirma la devolución y quedó a nivel sistema sin ser devuelta, pero 
    físicamente sí fue devuelta) o si no va a retirarla en el 
    momento de confirmar la reserva (alquiler).
    */

    
    public function calcularBicisDisponibles(int $cantidadNoDisponibles)
    {
        $totalBicicletas = $this->bicicletas()->count();
        $cantidadDisponibles = $totalBicicletas - $cantidadNoDisponibles;

        return $cantidadDisponibles;
    }

    public function verificarDisponibilidad(\DateTime $horario_retiro)
    {   
        $horario_formateado = $horario_retiro->format('Y-m-d H:i:s');

        // Me fijo las reservas que tiene la estación en ese horario de retiro
        // y cuento la cantidad de bicicletas (es decir, las no disponibles) que hay en ese momento.
        //Cuento las bicicletas que estan reservada en ese horario de retiro, pues pueden haber varias reservadas en esa misma hora, para la misma estación, y esa es la cantidad de bicicletas no disponibles que hay en esa estacion de retiro, pues son las bicicletas que han sido reservadas en el momento en que quiere el cliente reservar, en esa estación de retiro.
            $bicisNoDisponibles = Reserva::where('id_estacion_retiro', $this->id_estacion)
            ->where('fecha_hora_retiro', $horario_formateado)
            ->whereIn('id_estado', ['Alquilada', 'Activa'])
            ->count('id_bicicleta'); 
               
            dd($bicisNoDisponibles);
        return $bicisNoDisponibles;
     }
}
