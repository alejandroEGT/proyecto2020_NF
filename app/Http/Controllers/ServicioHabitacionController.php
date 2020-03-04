<?php

namespace App\Http\Controllers;

use App\Mail\correo;
use App\Serviciohabitacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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

    public function hotel_enviar_boleta_email(Request $r)
    {
        //return response()->json($r);

        
    //     $destinatario = 'alejandro.e.g.t29@gmail.com';//$r->email; 
    //     $destinatario = 'alejandro.e.g.t29@gmail.com';
    //     mail( 'alejandro.e.g.t29@gmail.com' , 'Mi título', 'lol lol lol y lol');
    //    return "enviado....";

        // $comment = 'Hi, This test feedback.';
        // $toEmail = "alejandro.e.g.t29@gmail.com";
        // Mail::to($toEmail)->send(new correo($comment));
        
        // return 'Email has been sent to '. $toEmail;
        $html = $r->html;
        $habitacion = $r->habitacion;
        $descripcion_nivel = $habitacion['descripcion_nivel'];
        $nivel = $habitacion['nivel'];
        $categoria = $habitacion['categoria'];
        $detalle = $habitacion['detalle'];

        $cliente = $r->head;
        $tabla = $r->tabla; 
        $lista = $r->lista;

        $total = $r->total;



       $body_tabla="";
        foreach ($lista as $key) {
           $body_tabla .="<tr>";
           $body_tabla .= "<td>".$key['cantidad']."</td>";
           $body_tabla .= "<td>".$key['descripcion']."</td>";
           $body_tabla .= "<td>".$key['precio_unitario']."</td>";
           $body_tabla .= "<td>".$key['precio_total']."</td>";
           $body_tabla .="</tr>";
        }
        
        Mail::send([], [], function ($message) 
        use(
            $html, 
            $descripcion_nivel,
            $nivel,
            $categoria,
            $detalle,
            $cliente,
            $tabla,
            $body_tabla,
            $total
        )
        {

            $message->from('nada@gmail.com', 'Equipo de "NEOFOX"');

            $message->to('alejandro.e.g.t29@gmail.com','to jano')
            ->setBody("hola")

            ->setBody("<h2> Hotel Restovar</h2>
                    <small style='text-align:center'>Pje rio Yakki - Los Angeles.</small>
                    <small style='text-align:center'><br>+56986523599</small>
                                        
                                            
                    <br>

                    <el-header>Datos de reserva y cliente</el-header><br>
                    <label style='margin:10px'><b>Edificio:</b>".$descripcion_nivel."</label><br>
                    <label style='margin:10px'><b>Habitación:</b>'Nivel ".$nivel.", numero o nombre '+habitacion.descripcion}}</label><br>
                    <label style='margin:10px'><b>Categoría:</b>".$categoria."</label><br>
                    <label style='margin:10px'><b>Detalle:</b>".$detalle."</label>
                    <br><br>
                    <label style='margin:10px'><b>Cliente:</b>".$cliente['nombre']."</label> <br>
                    <label style='margin:10px'><b>Identificador:</b>".$cliente['identificador']."</label> <br>
                    <label style='margin:10px'><b>Tipo identificador:</b>".$cliente['tipo_identificador']."</label> <br>
                    <label style='margin:10px'><b>Detalle de hospedaje:</b>".$cliente['detalle']."</label> <br><br>

                    <el-header>Venta directa</el-header>

                    <br>

                    <label style='margin:10px'><b>Codigo:</b>".$tabla['estado_historico_habitaciones_id']."</label> <br>
                    <label style='margin:10px'><b>Precio de hospedaje:</b>".$tabla['precio']."</label> <br><br>

                    <el-header>otros servicios (Tabla)</el-header><br>

                    <table border='1' style='border-collapse:separate;border-spacing:2px;border-color:#ddd;'>
                        <tr>
                            <td>Cantidad</td>
                            <td>Descripcion</td>
                            <td>Precio unitario</td>
                            <td>Precio total</td>
                        </tr>

                        ".$body_tabla."
                    </table>

                    <el-header>Total hospedaje</el-header>

                    <h2 style='margin:10px'>".$total."</h2>

                    ", 'text/html');
            // ->setBody($html, 'text/html');

    //  foreach ($lista as $key) {
    //                            echo "<td>".$key['cantidad']."</td>"
    //                            echo "<td>".$key['descripcion']."</td>"
    //                            echo "<td>".$key['precio_unitario']."</td>"
    //                            echo "<td>".$key['precio_total']."</td>"
    //                        }
    

        });



    }
}


//https://stackoverflow.com/questions/33939393/failed-to-authenticate-on-smtp-server-error-using-gmail

// <img height="50px" src="neofox-nav.png" alt="" style="text-align: center;"><br> <center><h2> Hotel Restovar</h2></center> <center><small style="text-align: center;">Pje rio Yakki - Los Angeles.</small> <small style="text-align: center;"><br>+56986523599</small></center> <br> <header class="el-header" style="height: 60px;">Datos de reserva y cliente</header> <br> <label style="margin: 10px;"><b>Edificio:</b>Edificio principal</label><br> <label style="margin: 10px;"><b>Habitación:</b>Nivel 1, numero o nombre 01</label><br> <label style="margin: 10px;"><b>Categoría:</b>Individual</label><br> <label style="margin: 10px;"><b>Detalle:</b>cama individual + television</label> <br><br> <label for="" style="margin: 10px;"><b>Cliente:</b> Alejandro Godoy</label><br> <label for="" style="margin: 10px;"><b>Identificador:</b> 188056520</label><br> <label for="" style="margin: 10px;"><b>Tipo identificador:</b> CDI</label><br> <label for="" style="margin: 10px;"><b>Detalle de hospedaje: </b>El cliente se queda de inmediato en el hotel</label> <br><br> <header class="el-header" style="height: 60px;">Venta directa</header> <br> <label style="margin: 10px;"><b>Codigo: </b>10</label><br> <label for="" style="margin: 10px;"><b>Precio de hospedaje: </b> $11.000</label><br> <header class="el-header" style="height: 60px;">otros servicios</header> <div class="el-table el-table--fit el-table--border el-table--scrollable-x el-table--enable-row-hover el-table--enable-row-transition" style="width: 100%;"><div class="hidden-columns"><div></div> <div></div> <div></div> <div></div></div><div class="el-table__header-wrapper"><table cellspacing="0" cellpadding="0" border="0" class="el-table__header" style="width: 720px;"><colgroup><col name="el-table_2_column_10" width="180"><col name="el-table_2_column_11" width="180"><col name="el-table_2_column_12" width="180"><col name="el-table_2_column_13" width="180"></colgroup><thead class=""><tr class=""><th colspan="1" rowspan="1" class="el-table_2_column_10     is-leaf"><div class="cell">Cantidad</div></th><th colspan="1" rowspan="1" class="el-table_2_column_11     is-leaf"><div class="cell">Descripcion</div></th><th colspan="1" rowspan="1" class="el-table_2_column_12     is-leaf"><div class="cell">Precio unitario</div></th><th colspan="1" rowspan="1" class="el-table_2_column_13     is-leaf"><div class="cell">Precio total</div></th></tr></thead></table></div><div class="el-table__body-wrapper is-scrolling-left"><table cellspacing="0" cellpadding="0" border="0" class="el-table__body" style="width: 720px;"><colgroup><col name="el-table_2_column_10" width="180"><col name="el-table_2_column_11" width="180"><col name="el-table_2_column_12" width="180"><col name="el-table_2_column_13" width="180"></colgroup><tbody><tr class="el-table__row"><td rowspan="1" colspan="1" class="el-table_2_column_10  "><div class="cell">↵                                                    1↵                                                </div></td><td rowspan="1" colspan="1" class="el-table_2_column_11  "><div class="cell">↵                                                    Pan con mantequilla↵                                                </div></td><td rowspan="1" colspan="1" class="el-table_2_column_12  "><div class="cell">↵                                                    $500↵                                                </div></td><td rowspan="1" colspan="1" class="el-table_2_column_13  "><div class="cell">↵                                                    $500↵                                                </div></td></tr><tr class="el-table__row"><td rowspan="1" colspan="1" class="el-table_2_column_10  "><div class="cell">↵                                                    1↵                                                </div></td><td rowspan="1" colspan="1" class="el-table_2_column_11  "><div class="cell">↵                                                    Bebida coca cola↵                                                </div></td><td rowspan="1" colspan="1" class="el-table_2_column_12  "><div class="cell">↵                                                    $800↵                                                </div></td><td rowspan="1" colspan="1" class="el-table_2_column_13  "><div class="cell">↵                                                    $800↵                                                </div></td></tr><tr class="el-table__row"><td rowspan="1" colspan="1" class="el-table_2_column_10  "><div class="cell">↵                                   


// <label style='margin:10px' for=""><b>Cliente:</b> ".$cliente." </label><br>
//                     <label style='margin:10px' for=""><b>Identificador:</b> {{ data.identificador }}</label><br>
//                     <label style='margin:10px' for=""><b>Tipo identificador:</b> {{ data.tipo_identificador }}</label><br>
//                     <label style='margin:10px' for=""><b>Detalle de hospedaje: </b>{{ data.detalle }}</label>
//                     <br><br>
//                     <el-header>Venta directa</el-header>
//                     <br>
//                     <label style='margin:10px'><b>Codigo: </b>{{ (data.estado_historico_habitaciones_id,10) }}</label><br>
//                     <label style='margin:10px' for=""><b>Precio de hospedaje: </b> {{ formatPrice(data.precio) }}</label><br>
//                     <br>