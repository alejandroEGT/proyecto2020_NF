<?php

namespace App\Http\Controllers;

use App\HotelHabitacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class HabitacionController extends Controller
{
    public function insertar_HotelHabitacion(Request $r)
    {
        try{
            DB::beginTransaction();

            $hh = new HotelHabitacion;
            $hh->niveles_id = $r->nivel;
            $hh->descripcion = $r->nombre;
            $hh->categoria_id = $r->categoria;
            $hh->detalle = $r->detalle;
            $hh->precio = $r->precio;
            $hh->activo = 'S';
            $hh->estado = 1;

            if ($hh->save()) {
                DB::commit();
                return ['estado'=>'success','mensaje'=>'Habitación creada'];
            }
            DB::rollBack();
            return ['estado'=>'failed','mensaje'=>'Error en el ingreso'];


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

    public function listar_hotel_habitacion($id)
    {
        $list = DB::select("SELECT 
                            n.descripcion descripcion_nivel,
                            n.nivel,
                            h.descripcion,
                            hc.categoria,
                            h.precio,
                            h.detalle,
                            h.activo,
                            h.id
                        from niveles_habitaciones h
                        inner join niveles n on n.id = h.niveles_id
                        inner join categoria_habitacion hc on hc.id = h.categoria_id
                         where niveles_id = $id");
        
        if (count($list) > 0) {
            return ['estado'=>'success', 'response'=>$list];
        }
        return ['estado'=>'failed','response'=>null];
    }

    public function listar_todo_hotel_habitacion()
    {

        $user = Auth::user()->id;
        $compania = $this->compania_by_user($user);

        $compania_id = $compania['response']->compania_id;

        $list = DB::select("SELECT 
                            h.id,
                            n.descripcion descripcion_nivel,
                            n.nivel,
                            h.descripcion,
                            hc.categoria,
                            h.precio,
                            h.detalle,
                            hh.estado,
                            hh.id estado_id
                        from niveles_habitaciones h
                        inner join niveles n on n.id = h.niveles_id
                        inner join categoria_habitacion hc on hc.id = h.categoria_id 
                        inner join estado_habitaciones hh on hh.id = h.estado
                        where compania_id = $compania_id and h.activo='S'
                        order by n.descripcion, nivel, h.descripcion
                        ");
        
        if (count($list) > 0) {
            return ['estado'=>'success', 'response'=>$list];
        }
        return ['estado'=>'failed','response'=>null];
    }

    public function compania_by_user($user)
    {

        $compania = DB::select("SELECT * FROM compania AS C
                                INNER JOIN  compania_usuarios AS cu on c.id = cu.compania_id
                                where  cu.user_id =  $user");
        if (count($compania)>0) {
            return ['estado'=>'success', 'response' => $compania[0]];
        }
    }

    public function traer_hotel_habitacion($habitacion_id)
    {
        $user = Auth::user()->id;
        $compania = $this->compania_by_user($user);

        $compania_id = $compania['response']->compania_id;

        $habitacion = DB::select("SELECT
                            h.id,
                            n.descripcion descripcion_nivel,
                            n.nivel,
                            h.descripcion,
                            hc.categoria,
                            h.precio,
                            h.detalle,
                            hh.estado,
                            hh.id estado_id
                        from niveles_habitaciones h
                        inner join niveles n on n.id = h.niveles_id
                        inner join categoria_habitacion hc on hc.id = h.categoria_id
                        inner join estado_habitaciones hh on hh.id = h.estado
                        where compania_id =$compania_id and h.id=$habitacion_id");

        if (count($habitacion)>0) {
            return response()->json(['estado'=>'success', 'response' => $habitacion[0]]);
        }

    }

    public function hotel_historial_habitacion($habitacion_id)
    {
        $listar = DB::select("SELECT 
                            ehh.id estado_historico_habitaciones_id,
                            to_char(ehh.fecha_desde,'dd/mm/yyyy') fecha_desde,
                            to_char(ehh.fecha_hasta,'dd/mm/yyyy') fecha_hasta,
                            ehh.hora_desde,
                            ehh.hora_hasta,
                            case
                                when estado_habitaciones_id = 2 then 'reservada'
                                when estado_habitaciones_id = 3 then 'ocupada'
                            end as estado_habitaciones,
                            pagada,
                            
                            case
                                when fin_servicio is null then 'Servicio pendiente'
                                when fin_servicio = 'S' then 'Servicio finalizado'
                            end as fin_servicio,
                            to_char(fecha_fin_servicio, 'dd/mm/yyyy') fecha_fin_servicio,
                            hora_fin_servicio,
                            detalle_fin_servicio,
                            rh.detalle,
                            ehh.precio,
                            nombre,
                            identificador,
                            tipo,
                            email
                            
                            
                        from niveles_habitaciones h
                        left join estado_historico_habitaciones ehh on h.id = ehh.nivel_habitacion_id
                        left join registro_hospedaje rh on rh.id = ehh.registro_hospedaje_id
                        left join cliente c on c.id = rh.cliente_id
                        left join tipo_fin_servicio tfs on cast(tfs.id as varchar) = ehh.tipo_fin_servicio
                        where h.id = ? order by ehh.created_at desc
                    ", [ $habitacion_id ]);
        
        if (count($listar) > 0) {
            foreach ($listar as $key) {
                $key->modal = false;
            }
            return $listar; 
        }

    }

    public function active_habitacion($id, $estado)
    {
        $hab = HotelHabitacion::find($id);

        if ($hab) {
            
            if ($estado == 'N') {
            $hab->activo = 'S';
            }

            if ($estado == 'S') {
                $hab->activo = 'N';
            }

            if ($hab->save()) {
               return [
                    'estado' => 'success',
                    'mensaje' => 'Cambio de estado'
               ];
            }
        }
    }
}
