<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudReservaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud_reserva', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('nombre');
            $table->text('tipo_identificador');
            $table->text('identificar');
            $table->text('contacto');
            $table->text('email')->nullable();
            $table->text('detalle')->nullable();
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
        Schema::dropIfExists('solicitud_reserva');
    }
}
