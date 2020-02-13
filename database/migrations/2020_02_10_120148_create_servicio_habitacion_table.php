<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicioHabitacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicio_habitacion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('estado_historico_habitaciones_id');
            $table->text('descripcion');
            $table->integer('cantidad');
            $table->bigInteger('precio_unitario');
            $table->bigInteger('precio_total');
            $table->char('activo',1);
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
        Schema::dropIfExists('servicio_habitacion');
    }
}
