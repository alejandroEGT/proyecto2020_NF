<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvitadoController extends Controller
{
    public function traer_disponibilidad(Request $r)
    {
        $f_desde = $r->fecha[0];
        $f_hasta = $r->fecha[1];

        $fecha_desde = date("Y-m-d", strtotime($f_desde));
        $fecha_hasta = date("Y-m-d", strtotime($f_hasta));

        $tipo = $r->select;


        $habitaciones = DB::select("SELECT
                    h.id,
                    n.descripcion descripcion_nivel,
                    n.nivel,
                    h.descripcion,
                    hc.id as categoria_id,
                    hc.categoria,
                    h.precio,
                    h.detalle,
                    hh.estado,
                    hh.id estado_id
                from niveles_habitaciones h
                inner join niveles n on n.id = h.niveles_id
                inner join categoria_habitacion hc on hc.id = h.categoria_id
                inner join estado_habitaciones hh on hh.id = h.estado
                where  hc.id = $tipo and hh.id = 1");

        if (count($habitaciones) > 0 || $tipo =='0') {
            return response()->json([
                'estado' => 'success', 
                'categoria_id' => $tipo,
                'fecha_desde'=> $fecha_desde,
                'fecha_hasta'=> $fecha_hasta,
                'response'=>$habitaciones
            ]);
        }



    }

    public function traer_disponibilidad2(Request $r)
    {
        $f_desde = $r->fecha_desde;
        $f_hasta = $r->fecha_hasta;
        $tipo = $r->select;

        if ($tipo == '0') {
            $habitaciones = DB::select("SELECT
                        h.id,
                        n.descripcion descripcion_nivel,
                        n.nivel,
                        h.descripcion,
                        hc.id as categoria_id,
                        hc.categoria,
                        h.precio,
                        h.detalle,
                        hh.estado,
                        hh.id estado_id
                    from niveles_habitaciones h
                    inner join niveles n on n.id = h.niveles_id
                    inner join categoria_habitacion hc on hc.id = h.categoria_id
                    inner join estado_habitaciones hh on hh.id = h.estado
                    where  hh.id = 1");
        }else{
            $habitaciones = DB::select("SELECT
                        h.id,
                        n.descripcion descripcion_nivel,
                        n.nivel,
                        h.descripcion,
                        hc.id as categoria_id,
                        hc.categoria,
                        h.precio,
                        h.detalle,
                        hh.estado,
                        hh.id estado_id
                    from niveles_habitaciones h
                    inner join niveles n on n.id = h.niveles_id
                    inner join categoria_habitacion hc on hc.id = h.categoria_id
                    inner join estado_habitaciones hh on hh.id = h.estado
                    where  hc.id = $tipo and hh.id = 1");
        }

            

        if (count($habitaciones) > 0 ) {
            foreach ($habitaciones as $key) {
                $key->activar = false;
            }
            return response()->json([
                'estado' => 'success', 
               
                'response'=>$habitaciones
            ]);
        }



    }
}
