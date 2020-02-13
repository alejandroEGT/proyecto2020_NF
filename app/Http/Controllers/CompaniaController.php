<?php

namespace App\Http\Controllers;

use App\User;
use App\Compania;
use App\CompaniaUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class CompaniaController extends Controller
{
    public function ingresar(Request $r)
    {
         try{
            DB::beginTransaction();
            $c = new Compania;
            $c->nombre = $r->nombre;
            $c->razon_social = $r->razon_social;
            $c->ubicacion = $r->ubicacion;
            $c->activo="S";
            if ($c->save()) {
                
                $u = new User;
                $u->nombre = $r->usuario;
                $u->email = $r->email;
                $u->password = bcrypt('123456');
                $u->rol = '1';

                if ($u->save()) {

                    $cu = new CompaniaUser;
                    $cu->compania_id = $c->id;
                    $cu->user_id = $u->id;
                    $cu->super_usuario = 'S';
                     $cu->activo = 'S';
                   if ($cu->save()) {

                        DB::commit();

                        return [
                            'estado'=>'success',
                            'mensaje'=>'Exito'
                        ];
                   }
                   DB::rollBack();
                   return [
                        'estado'=>'failed',
                        'mensaje'=>'Error'
                    ];
                }
                DB::rollBack();
                return [
                    'estado'=>'failed',
                    'mensaje'=>'Error'
                ];
                
            }
            DB::rollBack();
            return [
                    'estado'=>'failed',
                    'mensaje'=>'Error'
            ];
            
           

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
}
