<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HotelRegistroHospedaje extends Model
{
    protected $table = "registro_hospedaje";


    protected function registrar($cliente_id, $detalle)
    {
        $reg = $this;

        $reg->cliente_id = $cliente_id;
        $reg->detalle = $detalle;

        if ($reg->save()) {
            return [
                'estado' => 'success',
                'response' => $reg
            ];
        }else{
            return [
                'estado' => 'failed',
                'response' => null
            ];
        }
    }
}
