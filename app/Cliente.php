<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class Cliente extends Model
{
    protected $table = "cliente";

    protected function registrar($r)
    {   
        try{
            DB::beginTransaction();
            
            $verificar = $this::where([
                // 'activo' => 'S',
                'identificador' => $r->identificador
            ])->first();

            if ($verificar) {
                return [
                    'estado' => 'failed',
                    'mensaje' => 'Cliente ya registrado'
                ];
            }else{
                $cliente = $this;
                $cliente->nombre = $r->nombre;
                $cliente->tipo_identificador = $r->tipo_identificador;
                $cliente->identificador = $r->identificador;
                $cliente->email = !empty($r->email)? $r->email : '--'; 
                $cliente->contacto = $r->contacto;
                $cliente->direccion = $r->direccion;

                if ($cliente->save()) {
                     DB::commit();
                    return [
                        'estado' => 'success',
                        'mensaje' => 'Cliente registrado'
                    ];
                }
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

    protected function traer(string $ident)
    {
        $traer = DB::select("SELECT 
                                id,
                                nombre,
                                identificador,
                                case 
                                    when tipo_identificador = '1' then 'CDI'
                                    when tipo_identificador = '2' then 'PASAPORTE'
                                end as tipo
                            from cliente c where identificador = '$ident'");
        
        if (count($traer) > 0) {
            return [
                'estado'=>'success',
                'response'=>$traer[0]
            ];
        }else{
            return [
                'estado' => 'failed',
                'response' => null
            ];
        }
    }


    protected function traer_2(string $ident)
    {
        $traer = DB::select("SELECT 
                                id,
                                nombre,
                                identificador,
                               
                                case 
                                    when tipo_identificador = '1' then 'CDI'
                                    when tipo_identificador = '2' then 'PASAPORTE'
                                end as tipo
                            from cliente c where identificador = '$ident'");
        
        if (count($traer) > 0) {
            return [
                'estado'=>'success',
                'response'=>$traer[0]
            ];
        }else{
            return [
                'estado' => 'failed',
                'response' => null
            ];
        }
    }
}
