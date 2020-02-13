<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\solicitud_reserva;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function registrar_cliente(Request $r)
    {
        $cliente = Cliente::registrar($r);
        return $cliente;
    }

    public function traer_cliente($identificador)
    {
        $cliente = Cliente::traer($identificador);

        return $cliente;
    }

    public function traer_cliente_2($identificador, $solicitud_id)
    {
        $cliente = Cliente::traer_2($identificador);
        $fecha_reserva = solicitud_reserva::find($solicitud_id);

        return [
            'cliente'=>$cliente,
            'reserva'=>$fecha_reserva
        ];
    }

    public function todos_clientes()
    {
        $lista = Cliente::all();
        return $lista;
    }
}
