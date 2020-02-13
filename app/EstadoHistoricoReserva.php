<?php

namespace App;

use App\HotelHabitacion;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class EstadoHistoricoReserva extends Model
{
    protected $table = "estado_historico_habitaciones";

    protected function registrar($r, $rh_id)
    {
        $habitacion = HotelHabitacion::find($r->habitacion_id);
        

        if($habitacion->estado == 2 || $habitacion->estado == 3 ){

            
            return ['estado'=>'error','mensaje'=>'Habitacion en uso o reservada'];

        }else{
            
            $fdesde = date("Y-m-d", strtotime($r->fecha['fdesde']));
            $hdesde = $r->fecha['hdesde'];

            $fhasta = !empty($r->fecha['fhasta'])?date("Y-m-d", strtotime($r->fecha['fhasta'])):null;
            $hhasta = !empty($r->fecha['hhasta'])?$r->fecha['hhasta']:null;

            $verify = DB::table("niveles_habitaciones")->where([
                'id' => $r->habitacion_id
            ])->first();

            if($verify){
                
                if ($verify->estado == '2' || $verify->estado == '3') {
                    return [
                        'estado' => 'failed',
                        'mensaje' => 'Habitación ya ocupada o reservada'
                    ];
                }else{
                   
                        $insert = $this;

                        $insert->estado_habitaciones_id = $r->estado;
                        $insert->fecha_desde = $fdesde;
                        $insert->hora_desde = $hdesde;
                        $insert->fecha_hasta = $fhasta;
                        $insert->hora_hasta = $hhasta;
                        $insert->nivel_habitacion_id = $r->habitacion_id;
                        $insert->pagada=$r->pago;
                        $insert->precio = $habitacion->precio;
                        $insert->registro_hospedaje_id = $rh_id;
                        $insert->eliminado = 'N';

                        if ($insert->save()) {
                            return [
                                'estado'=>'success',
                                'response' => $insert
                            ];
                        }
                        return [
                            'estado'=>'failed',
                            'response'=>null
                        ];
                }
                
            }else{

                
                $insert = $this;

                $insert->estado_habitaciones_id = $r->estado;
                $insert->fecha_desde = $fdesde;
                $insert->hora_desde = $hdesde;
                $insert->fecha_hasta = $fhasta;
                $insert->hora_hasta = $hhasta;
                $insert->nivel_habitacion_id = $r->habitacion_id;
                $insert->pagada=$r->pago;
                $insert->registro_hospedaje_id = $rh_id;
                $insert->eliminado = 'N';

                if ($insert->save()) {
                    return [
                        'estado'=>'success',
                        'response' => $insert
                    ];
                }
                return [
                    'estado'=>'failed',
                    'response'=>null
                ];

            }
        }
    }
}

