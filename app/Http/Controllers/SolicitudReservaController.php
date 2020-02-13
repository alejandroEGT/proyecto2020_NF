<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\solicitud_reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class SolicitudReservaController extends Controller
{
    public function solicitud_reserva(Request $r)
    {
        // dd($r->all());
        try{
            DB::beginTransaction();
            
            $sr = new solicitud_reserva;
            $sr->nombre = $r->nombre;
            $sr->tipo_identificador = $r->tipo;
            $sr->identificar = $r->identificador;
            $sr->contacto = $r->contacto;
            $sr->email = $r->email;
            $sr->detalle = $r->detalle;
            $sr->activo = 'S';
            $sr->nivel_habitacion_id = $r->habitacion_id;
            $sr->fecha_desde = $r->fecha_desde;
            $sr->fecha_hasta = $r->fecha_hasta;

            if ($sr->save()) {
                DB::commit();
                return[
				'estado'  => 'success', 
                'mensaje' => 'Solicitud enviada, nos pondremos en contacto con usted a la brevedad',
            
            
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

    public function hotel_lista_soliciutd_reserv()
    {   
        $listar = DB::select("SELECT 
                                sol.id solicitud_id,
                                hab.id habitacion_id,
                                tipo_identificador as tipo_identificador_id,
                                case
                                    when tipo_identificador = '1' then 'CDI'
                                    when tipo_identificador = '2' then 'PASAPORTE'
                                END AS tipo_identificador,
                                nombre,
                                identificar,
                                contacto,
                                email,
                                sol.detalle  detalle_reserva,
                                hab.descripcion descripcion_habitacion,
                                precio,
                                categoria,
                                niv.descripcion,
                                niv.nivel
                            from solicitud_reserva sol
                            inner join niveles_habitaciones hab on hab.id = sol.nivel_habitacion_id
                            inner join niveles niv on niv.id = hab.niveles_id
                            inner join categoria_habitacion cat on cat.id = hab.categoria_id");

        if(count($listar)>0){

            foreach ($listar as $key) {
                 $key->modal = false;
                $clientes = Cliente::where('identificador', $key->identificar)->first();
                if ($clientes) {
                    $key->cliente_existe = 'S';
                }else{
                    $key->cliente_existe = 'N';
                }
            }


            return [
                'estado'=>'success',
                'response'=> $listar
            ];
        }else{
            return [
                'estado'=>'false',
                'response'=> null
            ];
        }
    }
}
