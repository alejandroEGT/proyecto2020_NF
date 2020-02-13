<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GraficosController extends Controller
{
    public function reservas_ocupaciones($anio)
    {

        $o_enero = $this->ocupadas('01', $anio);
        $o_febrero = $this->ocupadas('02', $anio); 
        $o_marzo = $this->ocupadas('03', $anio); 
        $o_abril = $this->ocupadas('04', $anio); 
        $o_mayo = $this->ocupadas('05', $anio);
        $o_junio = $this->ocupadas('06', $anio);
        $o_julio = $this->ocupadas('07', $anio);
        $o_agosto = $this->ocupadas('08', $anio);
        $o_septiembre = $this->ocupadas('09', $anio);
        $o_octubre = $this->ocupadas('10', $anio);
        $o_noviembre = $this->ocupadas('11', $anio);
        $o_diciembre = $this->ocupadas('12', $anio);

        $r_enero = $this->reservas('01', $anio);
        $r_febrero = $this->reservas('02', $anio); 
        $r_marzo = $this->reservas('03', $anio); 
        $r_abril = $this->reservas('04', $anio); 
        $r_mayo = $this->reservas('05', $anio);
        $r_junio = $this->reservas('06', $anio);
        $r_julio = $this->reservas('07', $anio);
        $r_agosto = $this->reservas('08', $anio);
        $r_septiembre = $this->reservas('09', $anio);
        $r_octubre = $this->reservas('10', $anio);
        $r_noviembre = $this->reservas('11', $anio);
        $r_diciembre = $this->reservas('12', $anio);

        return [
            'labels' => [
                        'Enero',
                        'Febrero',
                        'Marzo',
                        'Abril',
                        'Mayo',
                        'Junio',
                        'julio',
                        'agosto',
                        'septiembre',
                        'octubre',
                        'noviembre',
                        'diciembre'
            ],
            'datasets' =>[
                [
                    'label' => 'Reservas',
                    'backgroundColor' => '#F8C471',
                    'data' => [ $r_enero[0]->count
                               ,$r_febrero[0]->count
                               , $r_marzo[0]->count
                               , $r_abril[0]->count
                               , $r_mayo[0]->count
                               , $r_junio[0]->count
                               , $r_julio[0]->count
                               ,$r_agosto[0]->count
                               ,$r_septiembre[0]->count
                               ,$r_octubre[0]->count
                               ,$r_noviembre[0]->count
                               ,$r_diciembre[0]->count
                               ]
                ],
                [
                    'label' => 'Ocupaciones',
                    'backgroundColor' => '#EC7063',
                    'data' => [ $o_enero[0]->count
                               ,$o_febrero[0]->count
                               , $o_marzo[0]->count
                               , $o_abril[0]->count
                               , $o_mayo[0]->count
                               , $o_junio[0]->count
                               , $o_julio[0]->count
                               ,$o_agosto[0]->count
                               ,$o_septiembre[0]->count
                               ,$o_octubre[0]->count
                               ,$o_noviembre[0]->count
                               ,$o_diciembre[0]->count
                               ]
                ]
            ]
            
        ];
    }

    //habitaciones
    public function top_mas_ocupadas()
    {
        $list = DB::select("SELECT*from(select h.id habitacion_id, descripcion, detalle, categoria_id, categoria  from niveles_habitaciones h
                inner join categoria_habitacion c on c.id = h.categoria_id) hab
                inner join
                (select nivel_habitacion_id, count(*) from estado_historico_habitaciones where estado_habitaciones_id = 3 group by nivel_habitacion_id ) cant on cant.nivel_habitacion_id = hab.habitacion_id
                order by count desc limit 10");

        $nombre = [];
        $cant = [];
        foreach ($list as $key) {
            $nombre[]= $key->descripcion.' '.$key->detalle.' = Ocupaciones '.$key->count;
            $cant[]= $key->count;
        }

        return [
                'labels'=>$nombre,

                 'datasets' =>[
                     [
                        'label' => 'Ocupadas',
                        'backgroundColor' => [  '#F8C471',
                                                '#F1948A',
                                                '#85C1E9',
                                                '#EDBB99',
                                                '#F7DC6F',
                                                '#A2D9CE',
                                                '#AEB6BF',
                                                '#F1C40F',
                                                '#F8C471',
                                                '#EDBB99'                                            ],
                        'data' =>$cant
                     ]
                 ]
               ];
    }


    public function ocupadas($mes, $anio)
    {
        $cant = DB::select("SELECT count(*) from estado_historico_habitaciones ehh
                    where estado_habitaciones_id = 3 and to_char(fecha_desde, 'MM') = '$mes'
                    and to_char(fecha_desde, 'yyyy') = '$anio'
                    ");
        if ($cant) {
            return $cant;
        }else{
            return 0;
        }
    }

    public function reservas($mes, $anio)
    {
        $cant = DB::select("SELECT count(*) from estado_historico_habitaciones ehh
                    where estado_habitaciones_id = 2 and to_char(fecha_desde, 'MM') = '$mes'
                     and to_char(fecha_desde, 'yyyy') = '$anio'
                    ");
        if ($cant) {
            return $cant;
        }else{
            return 0;
        }
    }
    
}



// this.datacollection = {
//         labels: ['Enero','Febrero','Marzo','Abril','Mayo', 'Junio' , 'julio', 'agosto','septiembre',
//         'octubre','noviembre','diciembre'],
//         datasets: [
//           {
//             label: 'Reservas',
//             backgroundColor: '#F8C471',
//             data: [ 5, 6, 7, 8, 9, 10]
//           },
//           {
//             label: 'Ocupaciones',
//             backgroundColor: '#EC7063',
//             data: [ 20, 40, 50, 20, 50, 40]
//           },
//         ]
//       }