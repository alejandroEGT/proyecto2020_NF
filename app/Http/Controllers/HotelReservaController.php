<?php

namespace App\Http\Controllers;

use DateTime;
use App\HotelHabitacion;
use App\solicitud_reserva;
use Illuminate\Http\Request;
use App\EstadoHistoricoReserva;
use App\HotelRegistroHospedaje;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class HotelReservaController extends Controller
{
    
  
    public function insertar_reserva(Request $r)
    {
        
        try{
            DB::beginTransaction();
            $val = (!empty($r->solicitud_reserva_id))?true:false;

         //registrar hospedaje
         $rh = new HotelRegistroHospedaje;
         $rh->cliente_id = $r->cliente;
         $rh->detalle = $r->detalle;
         if ($rh->save()) {
             
             $ehr = EstadoHistoricoReserva::registrar($r, $rh->id);
            // dd($ehr);

             if ($ehr['estado']=='success') {
                 
                $hab = HotelHabitacion::find($r->habitacion_id);
                $hab->estado = $r->estado;
                if ($hab->save()) {

                    if ($val) {
                       $sr = solicitud_reserva::find($r->solicitud_reserva_id);
                       $sr->activo = 'N';
                       $sr->save(); // aqui desactivamos la solicitud de reserva
                    }
                    DB::commit();
                    return[
                        'estado'=>'success',
                        'mensaje'=>'Habitación asignada'
                    ];
                }
             }
            //  dd($ehr['estado']);
             if ($ehr['estado']=='error') {
                 DB::rollBack();
                 return[
                        'estado'=>'failed',
                        'mensaje'=>'Habitación en uso o reservada'
                    ];
             }

             DB::rollBack();
			return[
				'estado'  => 'failed', 
                'mensaje' => 'No se ha podido seguir con el proceso de guardado, intente nuevamente o verifique sus datos',
                // 'error' => $e
			];
         }
         
         

        }catch(QueryException $e){
            DB::rollBack();
			return[
				'estado'  => 'failed', 
                'mensaje' => 'QEx: No se ha podido seguir con el proceso de guardado, intente nuevamente o verifique sus datos',
                'error' => $e
			];
		}
		catch(\Exception $e){
            DB::rollBack();
			return[
				'estado'  => 'failed', 
                'mensaje' => 'Ex: No se ha podido seguir con el proceso de guardado, intente nuevamente o verifique sus datos',
                'error' => $e
			];
		}
        

    }

    public function traer_hotel_estado_habitacopn($hab_id)
    {
        $traer = DB::select("SELECT 
                        ehh.id estado_historico_habitaciones_id,
                        ehh.nivel_habitacion_id,
                        cliente_id,
                        nombre,
                        identificador,
                        case 
                            when tipo_identificador = '1' then 'CDI'
                            when tipo_identificador = '2' then 'PASAPORTE'
                        end as tipo_identificador,
                        -- TO_CHAR(ehh.fecha_desde, 'DD-MM-YYYY')
                        to_char(ehh.fecha_desde,'dd/mm/yyyy') fecha_desde,
                        ehh.hora_desde,

                         to_char(ehh.fecha_hasta, 'dd/mm/yyyy') fecha_hasta,
                        ehh.hora_hasta,
                        detalle,
                        ehh.estado_habitaciones_id,
                        estado,
                        pagada,
                        precio

                        from estado_historico_habitaciones ehh
                        inner join registro_hospedaje rh on rh.id = ehh.registro_hospedaje_id
                        inner join cliente c on c.id = rh.cliente_id
                        inner join estado_habitaciones eh on eh.id = ehh.estado_habitaciones_id
                        where ehh.nivel_habitacion_id = $hab_id and fin_servicio is null ");
        
        if (count($traer)>0) {
            return [
                'estado' => 'success',
                'response' => $traer[0],
            ];
        }
    }


    public function anulacion()//anular como tambien completar el servicio
    {
        $tipo = DB::table("tipo_fin_servicio")->get();
        if (count($tipo) > 0 ) {
            return ['estado'=>'success', 'response'=>$tipo];
        }
        return ['estado'=>'failed', 'response'=> null];
    }

    public function hotel_cambiar_estado_habitacion(Request $r)
    {
        try{
            DB::beginTransaction();

            $habitacion = HotelHabitacion::find($r->habitacion_id);
            if ($habitacion) {
                $habitacion->estado = $r->habitacion_estado;
                if ($habitacion->save()) {
                    $estado_hab = EstadoHistoricoReserva::where([
                        'nivel_habitacion_id' => $r->habitacion_id,
                        'fin_servicio' => null
                    ])->first();

                    if($estado_hab){

                        $estado_hab->estado_habitaciones_id = $r->habitacion_estado;
                        if ($estado_hab->save()) {
                            DB::commit();
                            return [
                                'estado'=>'success',
                                'mensaje'=>'El estado se actualizó correctamente'
                            ];
                        }
                        DB::rollBack();
                        return [
                            'estado'=>'failed',
                            'mensaje'=>'Error al actualizar'
                        ];
                        
                    }
                    DB::rollBack();
                    return [
                        'estado'=>'failed',
                        'mensaje'=>'Error al actualizar'
                    ];
                    
                }
                DB::rollBack();
                return [
                    'estado'=>'failed',
                    'mensaje'=>'Error al actualizar'
                ];
            }


        }catch(QueryException $e){
            DB::rollBack();
			return[
				'estado'  => 'failed', 
                'mensaje' => 'QEx: No se ha podido seguir con el proceso de guardado, intente nuevamente o verifique sus datos',
                'error' => $e
			];
		}
		catch(\Exception $e){
            DB::rollBack();
			return[
				'estado'  => 'failed', 
                'mensaje' => 'Ex: No se ha podido seguir con el proceso de guardado, intente nuevamente o verifique sus datos',
                'error' => $e
			];
		}
    }

    public function hotel_finalizar_proceso_habitacion(Request $r)
    {
         DB::beginTransaction();
        $fecha_fin = date("Y-m-d", strtotime($r->fin_fecha['fecha_fin']));
        $estado_hab = EstadoHistoricoReserva::where([
                        'id' => $r->est_hist_habitacion_id,
                        'fin_servicio' => null
                    ])->first();
        if ($estado_hab) {
            $estado_hab->fin_servicio = 'S';
            $estado_hab->fecha_fin_servicio = $fecha_fin;
            $estado_hab->hora_fin_servicio =  $r->fin_fecha['hora_fin'];
            $estado_hab->tipo_fin_servicio = $r->tipo_f_serv;
            $estado_hab->detalle_fin_servicio = $r->detalle;

            if ($estado_hab->save()) {
                // dd($r->est_hist_habitacion_id);
                $habitacion = HotelHabitacion::find($r->habitacion_id);
                // dd($habitacion);
                if ($habitacion) {
                    
                    $habitacion->estado = 1;

                    if ($habitacion->save()) {
                         DB::commit();
                        return[
                            'estado'=>'success',
                            'mensjae'=>'Finalización del proceso habitacional con exito'
                        ];
                    }
                    DB::rollBack();
                    return[
                            'estado'=>'failed',
                            'mensjae'=>'Error al finalizar proceso',
                            'ex'=>'primer'
                    ];

                        
                }
                DB::rollBack();
                return[
                            'estado'=>'failed',
                            'mensjae'=>'Error al finalizar proceso',
                            'ex'=>'pre'
                    ];
            }
            DB::rollBack();

            return[
                    'estado'=>'failed',
                    'mensjae'=>'Error al finalizar proceso',
                    'ex'=>'fin'
                ];
        }
    }

    public function hotel_actualizar_reserva(Request $r)
    {
        $save1 = false;
        $save2 = false;
        //return response()->json($r);
        //dd((string)$r->fecha_desde);
        $d_dia = substr($r->fecha_desde, 0, 2);
        $d_mes = substr($r->fecha_desde, -7, 2);
        $d_anio = substr($r->fecha_desde, -4, 4);

        $h_dia = substr($r->fecha_hasta, 0, 2);
        $h_mes = substr($r->fecha_hasta, -7, 2);
        $h_anio = substr($r->fecha_hasta, -4, 4);
        


        $ehr = EstadoHistoricoReserva::find($r->estado_historico_habitaciones_id);
        $ehr->fecha_desde = $d_anio.'-'.$d_mes.'-'.$d_dia;
        $ehr->fecha_hasta = $h_anio.'-'.$h_mes.'-'.$h_dia;
        $ehr->pagada = $r->pago;
        $ehr->hora_desde = $r->hora_desde;
        $ehr->hora_hasta = $r->hora_hasta;
        $ehr->precio = $r->precio;
        if ($ehr->save()) {
            $save1 = true;
        }

        $rh = HotelRegistroHospedaje::find($ehr->registro_hospedaje_id);

        $rh->detalle = $r->detalle;
        if ($rh->save()) {
            $save2 = true;
        }

        if ($save1 == true && $save2 == true) {
            
            return [
                'estado' => 'success',
                'mensaje' => 'Algunos datos del formulario se han actualizado'
            
            ];
        }

        return [
                'estado' => 'failed',
                'mensaje' => 'No se han actualizado los datos del formulario'
            
        ];



        
    }
}
