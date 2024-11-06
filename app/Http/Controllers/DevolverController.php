<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Reserva; // Importar el modelo Reserva
use Illuminate\Http\Request;
use App\Models\Calificacion; // Importar el modelo Reserva
use App\Models\Danio; // Importar el modelo Reserva
use Carbon\Carbon; // Asegúrate de importar Carbon
use App\Models\Cliente; // Importar el modelo Reserva


class DevolverController extends Controller
{

    // -------------
    // ALQUILAR
    // -------------

    public function mostrarVista()
    {
        $usuarioId = Auth::id(); // Obtiene el ID del usuario autenticado
        
        //Obtener el id_restacion_retiro o devolucion

        //aunque la devuelva otra persona (o sea no el cliente que hizo la reserva), la consulta SQL no cambia en nada.
        $id_estacion_retiro= Reserva ::where("id_cliente_reservo", $usuarioId)
        ->where("id_estado","2")
        ->pluck('id_estacion_retiro')
        ->first();

        $id_estacion_devolucion= Reserva ::where("id_cliente_reservo", $usuarioId)
        ->where("id_estado","2")
        ->pluck('id_estacion_devolucion')
        ->first();

        //obtener el par id_tipo_danio  -  decripcion 

    $danios = Danio::All();
    $datos = [];

    foreach ($danios as $danio) {
        $datos[$danio->id_danio] = [
        'descripcion' => $danio->descripcion, // Asegúrate de que este campo existe en tu modelo
        'tipo_danio' => $danio->id_tipo_danio // Asegúrate de que este campo existe en tu modelo
        ];   
    }

        return view('cliente.devolver', compact('id_estacion_retiro','id_estacion_devolucion', 'datos'));

    }

    public function guardarDetalles($hora_devolucion,$fecha_hora_devolucion, $puntaje, $puntaje_cliente,$danios){

        session()->put('detalles', [
            'hora_devolucion' => $hora_devolucion,
            'hora_devolucion_real' => $fecha_hora_devolucion,
            'puntaje_obtenido' => $puntaje,
            'puntaje_actualizado' => $puntaje_cliente,
            'danios' => $danios,
        ]);
    }
    public function guardarCalif(Request $request){
    
    try {

        //retiro_o_devolucion
        \Log::info('Valor de calificación recibido: ' . $request->calificacion);
        \Log::info('ID de estación recibido: ' . $request->id_estacion);

        $id_tipo_calificacion=$request->calificacion;
        $id_estacion=$request->id_estacion;
        
        $calificacion = new Calificacion();
        $calificacion->id_estacion = $id_estacion; // Asignar un valor a un atributo
        $calificacion->id_tipo_calificacion = $id_tipo_calificacion;    // Asignar un valor de estación, por ejemplo
        
        $calificacion->save(); // Guardar en la base de datos    

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        // Registrar el error
        \Log::error('Error al guardar la calificación: ' . $e->getMessage());
        return response()->json(['success' => false, 'error' => 'Error interno'], 500);
    }



    }   
    public function guardarDanios(Request $request){
        $danios=$request->danios;
        session()->put('danios', $danios);

        return response()->json(['success' => true]);
    }


    
    public function evaluarMulta ($puntaje){
        if($puntaje<0){
            //Realizar multa. Maxi Mansilla.
        }
    }


    //Si has seleccionado daños, te evalúo tu puntaje como usuario.
    //El problema es que ahora necesito evaluar tu puntaje cuando NO has hecho danios a la bicicleta.
    public function evaluarPuntaje (Request $request){
    try {

        //Evalúo cuando debo evaluar danios y tiempos de entrega.
        if (session()->has('danios')) {

        $danios = session('danios');
        
        //retiro_o_devolucion
        $id_cliente = auth()->id(); // O puedes usar auth()->user()->id;

        
        // Filtrar las reservas del cliente con id_estado = '2'
        $reserva = Reserva::where('id_cliente_reservo', $id_cliente)
            ->where('id_estado', '2')
            ->first(); // Obtiene la primera reserva que cumpla con los criterios
        
        $hora_devolucion = $reserva->hora_devolucion;




        // Verificar si se encontró una reserva
        if ($reserva) {
            // Almacenar la fecha_hora_devolución en una variable
            $fecha_hora_devolucion = Carbon::parse($reserva->fecha_hora_devolucion); // Convierte la fecha_hora_devolucion a un objeto Carbon

        } else {

        }

        $fecha_hora_actual = Carbon::now(); // Devuelve la fecha y hora actual en formato Carbon

        //reglas de negocio.

        // Sumar 10 minutos. Es el tiempo de tolerancia en la devolución
        $nueva_fecha_hora_devolucion = $fecha_hora_devolucion->copy()->addMinutes(10); // Usamos copy() para no modificar el original
        $fecha_hora_devolucion_mas_doce = $fecha_hora_devolucion->copy()->addHours(12); // Usamos copy() para no modificar el original
        $fecha_hora_devolucion_mas_veinticuatro = $fecha_hora_devolucion->copy()->addHours(24); // Usamos copy() para no modificar el original


        // Depuración
        \Log::info('Fecha y hora actual: ' . $fecha_hora_actual);
        \Log::info('Fecha y hora de devolución: ' . $fecha_hora_devolucion);
        \Log::info('Nueva fecha de devolución: ' . $nueva_fecha_hora_devolucion);
        \Log::info('Fecha de devolución + 12 horas: ' . $fecha_hora_devolucion_mas_doce);
        \Log::info('Fecha de devolución + 24 horas: ' . $fecha_hora_devolucion_mas_veinticuatro);

        $NoRecuperable = in_array("2", $danios); //Si se encuentra un daño no recuperable, devuelve true. Si devuelve false, es porque es un daño recuperable ya que no hay daños no recuperables seleccionados. easy


        $cliente = Cliente::find($id_cliente); // Ajusta el nombre del modelo según tu estructura
        $puntaje = $cliente->puntaje; // Ajusta el nombre de la columna si es necesario



        //entrega en tiempo y forma.
        if($fecha_hora_actual->isBefore($nueva_fecha_hora_devolucion)){ //fecha_hora_Devolucion es el tiempo máximo de alquiler
            if(!$NoRecuperable){ //es recuperable
            $cliente->puntaje += -40; 
            // Guardar los cambios en la base de datos
            $cliente->save();
            $puntaje= -40;
            }else{
                $cliente->puntaje += -40*3; 
                // Guardar los cambios en la base de datos
                $cliente->save();
                $puntaje= -40*3;
            }

            $this->evaluarMulta($puntaje);
            $puntaje_cliente= $cliente->puntaje;
            session()->forget('danios');  // Elimina la clave 'clave' de la sesión

            $this->guardarDetalles($hora_devolucion,$fecha_hora_devolucion,$puntaje,$puntaje_cliente,$danios);

        return response()->json(['success' => true, 'message' => "entre en el 1er condicional  "."puntaje añadido al cliente:".$puntaje]);

        }else if( $fecha_hora_actual->isAfter($fecha_hora_devolucion) && $fecha_hora_actual->isBefore($fecha_hora_devolucion_mas_doce)){
            if(!$NoRecuperable){ //daños recuperables
                $cliente->puntaje += -60; 
                // Guardar los cambios en la base de datos
                $cliente->save();
                $puntaje= -60;

            }else{ //Daños no recuperables
                $cliente->puntaje += -60*3; 
                // Guardar los cambios en la base de datos
                $cliente->save();
                $puntaje= -60*3;

            }  
            $this->evaluarMulta($puntaje);
            $puntaje_cliente= $cliente->puntaje;
            session()->forget('danios');  // Elimina la clave 'clave' de la sesión

           // $this->guardarDetalles($hora_devolucion,$fecha_hora_devolucion,$puntaje,$puntaje_cliente,$danios);


            return response()->json(['success' => true, 'message' => "entre en el 2do condicional  "."  puntaje añadido al cliente:".$puntaje]);

        }else if( $fecha_hora_actual->isAfter($fecha_hora_devolucion_mas_doce) && $fecha_hora_actual->isBefore($fecha_hora_devolucion_mas_veinticuatro)){
            
            if(!$NoRecuperable){ //daños recuperables
                $cliente->puntaje += -90; 
                // Guardar los cambios en la base de datos
                $cliente->save();
                $puntaje= -90;

    
            }else{ //Daños no recuperables
                $cliente->puntaje += -90*3; 
                // Guardar los cambios en la base de datos
                $cliente->save();
                $puntaje= -90*3;

            }
            
            $this->evaluarMulta($puntaje);
            $puntaje_cliente= $cliente->puntaje;
            session()->forget('danios');  // Elimina la clave 'clave' de la sesión

          //  $this->guardarDetalles($hora_devolucion,$fecha_hora_devolucion,$puntaje,$puntaje_cliente,$danios);

            return response()->json(['success' => true, 'message' => "entre en el 3er condicional  "."puntaje añadido al cliente  :".$puntaje]);

        }else{ //si me atrasé fecha_hora_devolución + 99999999999999 horas
            if(!$NoRecuperable){ //daños recuperables
                $cliente->puntaje += -1000; 
                // Guardar los cambios en la base de datos
                $cliente->save();
                $puntaje= -1000;

    
            }else{ //Daños no recuperables
                $cliente->puntaje += -1000; 
                // Guardar los cambios en la base de datos
                $cliente->save();
                $puntaje= -1000;

            }


            $this->evaluarMulta($puntaje);
            $puntaje_cliente= $cliente->puntaje;
            session()->forget('danios');  // Elimina la clave 'clave' de la sesión

           // $this->guardarDetalles($hora_devolucion,$fecha_hora_devolucion,$puntaje,$puntaje_cliente,$danios);


            return response()->json(['success' => true, 'message' =>"entre en el 4to condicional:  "."puntaje añadido al cliente:".$puntaje]);

        }

   
   
   
    }else{  //evalúo tu puntaje cuando no le has hecho danios a la bicicleta.
        
        //retiro_o_devolucion
        $id_cliente = auth()->id(); // O puedes usar auth()->user()->id;

        
        // Filtrar las reservas del cliente con id_estado = '2'
        $reserva = Reserva::where('id_cliente_reservo', $id_cliente)
            ->where('id_estado', '2')
            ->first(); // Obtiene la primera reserva que cumpla con los criterios

        $hora_devolucion = $reserva->hora_devolucion;

        // Verificar si se encontró una reserva
        if ($reserva) {
            // Almacenar la fecha_hora_devolución en una variable
            $fecha_hora_devolucion = Carbon::parse($reserva->fecha_hora_devolucion); // Convierte la fecha_hora_devolucion a un objeto Carbon


        } else {

        }

        $fecha_hora_actual = Carbon::now(); // Devuelve la fecha y hora actual en formato Carbon

        //reglas de negocio.

        // Sumar 10 minutos. Es el tiempo de tolerancia en la devolución
        $nueva_fecha_hora_devolucion = $fecha_hora_devolucion->copy()->addMinutes(10); // Usamos copy() para no modificar el original
        $fecha_hora_devolucion_mas_doce = $fecha_hora_devolucion->copy()->addHours(12); // Usamos copy() para no modificar el original
        $fecha_hora_devolucion_mas_veinticuatro = $fecha_hora_devolucion->copy()->addHours(24); // Usamos copy() para no modificar el original

        $cliente = Cliente::find($id_cliente); // Ajusta el nombre del modelo según tu estructura
        $puntaje = $cliente->puntaje; // Ajusta el nombre de la columna si es necesario



        //entrega en tiempo y forma.
        if($fecha_hora_actual->isBefore($nueva_fecha_hora_devolucion)){ //fecha_hora_Devolucion es el tiempo máximo de alquiler
                $cliente->puntaje += 5; 
                // Guardar los cambios en la base de datos
                $cliente->save();
                $puntaje=5;
            $this->evaluarMulta($puntaje);
            $puntaje_cliente= $cliente->puntaje;
            session()->forget('danios');  // Elimina la clave 'clave' de la sesión

         //   $this->guardarDetalles($hora_devolucion,$fecha_hora_devolucion,$puntaje,$puntaje_cliente,$danios);


            
        return response()->json(['success' => true, 'message' => "entre en el 1er condicional"."puntaje añadido al cliente:  ".$puntaje]);

        }else if( $fecha_hora_actual->isAfter($fecha_hora_devolucion) && $fecha_hora_actual->isBefore($fecha_hora_devolucion_mas_doce)){
                $cliente->puntaje += -5; 
                // Guardar los cambios en la base de datos
                $cliente->save();

                $puntaje=-5;
                $this->evaluarMulta($puntaje);
                $puntaje_cliente= $cliente->puntaje;
                session()->forget('danios');  // Elimina la clave 'clave' de la sesión
    
              //  $this->guardarDetalles($hora_devolucion,$fecha_hora_devolucion,$puntaje,$puntaje_cliente,$danios);
    
    
            return response()->json(['success' => true, 'message' => "entre en el 3er condicional"."puntaje añadido al cliente:  ".$puntaje]);

        }else if( $fecha_hora_actual->isAfter($fecha_hora_devolucion_mas_doce) && $fecha_hora_actual->isBefore($fecha_hora_devolucion_mas_veinticuatro)){
            
                $cliente->puntaje += -50; 
                // Guardar los cambios en la base de datos
                $cliente->save();
                $puntaje=-50;;

                $this->evaluarMulta($puntaje);
                $puntaje_cliente= $cliente->puntaje;
                session()->forget('danios');  // Elimina la clave 'clave' de la sesión
    
              //  $this->guardarDetalles($hora_devolucion,$fecha_hora_devolucion,$puntaje,$puntaje_cliente,$danios);
    
            return response()->json(['success' => true, 'message' => "entre en el 4to condicional"."puntaje añadido al cliente:  ".$puntaje]);

        }else{ //si me atrasé fecha_hora_devolución + 99999999999999 horas
    
            $cliente->puntaje += -1000; 
            // Guardar los cambios en la base de datos
            $cliente->save();
            $puntaje=-1000;
        
            $this->evaluarMulta($puntaje);
            $puntaje_cliente= $cliente->puntaje;
            session()->forget('danios');  // Elimina la clave 'clave' de la sesión

         //   $this->guardarDetalles($hora_devolucion,$fecha_hora_devolucion,$puntaje,$puntaje_cliente,$danios);
           
            return response()->json(['success' => true, 'message' => '99999999999999']);

        }
    }
   
   
   
    } catch (\Exception $e) {
        // Registrar el error
        \Log::error('Error al guardar la calificación: ' . $e->getMessage());
        return response()->json(['success' => false, 'error' => 'Error interno'], 500);
    }

    }


    
}

