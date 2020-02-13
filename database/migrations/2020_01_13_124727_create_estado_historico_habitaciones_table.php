<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstadoHistoricoHabitacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estado_historico_habitaciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('nivel_habitacion_id');
            $table->integer('registro_hospedaje_id');
            $table->datetime('fecha_desde');
            $table->datetime('fecha_hasta');
            $table->char('estado_habitaciones_id',1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estado_historico_habitaciones');
    }
}
