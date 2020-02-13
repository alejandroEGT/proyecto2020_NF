<?php

namespace App\Http\Controllers;

use App\Nivel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class NivelController extends Controller
{
    public function ingresar(Request $r)
    {
        $user = Auth::user()->id;
        $compania = $this->compania_by_user($user);

       if ($compania['estado'] == 'success') {
            $n = new Nivel;

            $n->descripcion = $r->descripcion;
            $n->nivel = $r->nivel;
            $n->compania_id = $compania['response']->compania_id;
            $n->user_id =  $user;
            $n->activo = "S";

            if ($n->save()) {
                return [ 'estado' => 'success', 'mensaje' => 'Nivel ingresado' ];
            }
        }


        

    }

    public function listar()
    {
        $user = Auth::user()->id;
        $compania = $this->compania_by_user($user);

        if ($compania['estado'] == 'success') {

            $listar = Nivel::select([
                'id','descripcion','nivel'
            ])->where([
                'compania_id' => $compania['response']->compania_id,
                'user_id' => $user
            ])->get();

            if ($listar) {
                return [
                    'estado' => 'success',
                    'response' => $listar
                ];
            }
        }
    }

    public function traer_nivel($id)
    {
        $user = Auth::user()->id;
        $compania = $this->compania_by_user($user);

         if ($compania['estado'] == 'success') {
              $listar = Nivel::where([
                'compania_id' => $compania['response']->compania_id,
                'user_id' => $user,
                'id' => $id
            ])->first();
            if ($listar) {
                return [
                    'estado' => 'success',
                    'response' => $listar
                ];
            }
         }
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
}
