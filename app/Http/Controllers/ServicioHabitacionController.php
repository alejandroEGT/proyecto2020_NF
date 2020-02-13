<?php

namespace App\Http\Controllers;

use App\Serviciohabitacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServicioHabitacionController extends Controller
{
    protected $table = "servicio_habitacion";


    public function agregar_servicio(Request $r)
    {
        $ser = new Serviciohabitacion;

        $ser->estado_historico_habitaciones_id = $r->estado_historico_habitaciones_id;
        $ser->descripcion = $r->descripcion;
        $ser->cantidad = $r->cantidad;
        $ser->precio_unitario = (int)$r->precio;
        $ser->precio_total = $r->precio_total;
        $ser->activo = 'S';
        
        if ($ser->save()) {
            return [
                'estado' => 'success',
                'mensaje' => 'Servicio añadido al hospedaje'
            ];
        }else{
            return [
                'estado' => 'failed',
                'mensaje' => 'Error al añadir el servicio'
            ];
        }
    }

    public function listar($estado_historico_habitaciones_id)
    {
        $listar = Serviciohabitacion::where([
                'activo' => 'S', 
                'estado_historico_habitaciones_id' => $estado_historico_habitaciones_id
            ])->get();
        
            if ($listar) {
                $sum = 0;
                foreach ($listar as $key) {
                    $sum = $sum + $key->precio_total;
                }

                return ['listar'=> $listar,   'total' => $sum];
            }
    }

    public function traer_cliente_boleta($id)
    {
       $list = DB::select("SELECT
                            c.id cliente_id,
                            nombre,
                            identificador,
                            case 
                                when tipo_identificador = '1' then 'CDI'
                                when tipo_identificador = '2' then 'PASAPORTE'
                            end as tipo_identificador,
                            detalle,
                            ehh.precio
                        from cliente c
                        inner join registro_hospedaje rh on rh.cliente_id = c.id
                        inner join estado_historico_habitaciones ehh on ehh.registro_hospedaje_id = rh.id
                        where ehh.id = $id");
        if (count($list)>0) {
            return [
                'estado' => 'success',
                'response' => $list
            ];
        }
    }
}
