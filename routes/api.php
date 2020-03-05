<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('auth/login', 'AuthController@login');

Route::post("traer_disponibilidad","InvitadoController@traer_disponibilidad");
Route::post("traer_disponibilidad2","InvitadoController@traer_disponibilidad2");

Route::post('solicitud_reserva','SolicitudReservaController@solicitud_reserva');

Route::group(['middleware' => 'auth.jwt'], function () {

     Route::get('auth/user', 'AuthController@user');
    Route::post('auth/logout', 'AuthController@logout');


    
    Route::post('ingresar_nivel', 'NivelController@ingresar');
    Route::get('listar_niveles', 'NivelController@listar');
    Route::get('traer_nivel/{id}', 'NivelController@traer_nivel');

    Route::post('insertar_habitacion', 'HabitacionController@insertar_HotelHabitacion');
    Route::get('listar_habitaciones/{id}', 'HabitacionController@listar_hotel_habitacion');
    Route::get('listar_todas_habitaciones', 'HabitacionController@listar_todo_hotel_habitacion');
    Route::get('traer_hotel_habitacion/{habitacion_id}', 'HabitacionController@traer_hotel_habitacion');
    Route::get('active_habitacion/{id}/{estado}', 'HabitacionController@active_habitacion');

    Route::post('registrar_cliente', 'ClienteController@registrar_cliente');
    Route::get('traer_cliente/{identificador}', 'ClienteController@traer_cliente');
    Route::get('traer_cliente_2/{identificador}/{sol_id}', 'ClienteController@traer_cliente_2');
    Route::post('insertar_reserva', 'HotelReservaController@insertar_reserva');
    Route::get('traer_hotel_estado_habitacion/{hab_id}', 'HotelReservaController@traer_hotel_estado_habitacopn');

    Route::get('traer_tipo_fin_servicio','HotelReservaController@anulacion');

    Route::post("hotel_cambiar_estado_habitacion","HotelReservaController@hotel_cambiar_estado_habitacion");
    Route::post("hotel_finalizar_proceso_habitacion","HotelReservaController@hotel_finalizar_proceso_habitacion");
     
    Route::get("hotel_historial_habitacion/{habitacion_id}", "HabitacionController@hotel_historial_habitacion");
    Route::post("hotel_actualizar_reserva","HotelReservaController@hotel_actualizar_reserva");


    Route::post("agregar_servicio","ServicioHabitacionController@agregar_servicio");
    Route::get("listar_servicio/{estado_historico_habitaciones_id}","ServicioHabitacionController@listar");
    Route::get("traer_cliente_boleta/{est_hist_hab_id}", "ServicioHabitacionController@traer_cliente_boleta");
    
     Route::post("hotel_enviar_boleta_email","ServicioHabitacionController@hotel_enviar_boleta_email");
    // hotel_enviar_boleta_email
    // CLIENTES
    Route::get("todos_clientes", "ClienteController@todos_clientes");


    //graficos
    Route::get('reservas_ocupaciones/{anio}','GraficosController@reservas_ocupaciones');
    Route::get('top_mas_ocupadas','GraficosController@top_mas_ocupadas');
    

    //solicitud de reservas

    // Route::post('solicitud_reserva','SolicitudReservaController@solicitud_reserva');
    Route::get('hotel_lista_soliciutd_reserv','SolicitudReservaController@hotel_lista_soliciutd_reserv');
    
    
});