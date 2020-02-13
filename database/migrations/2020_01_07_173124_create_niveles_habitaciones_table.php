<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNivelesHabitacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('niveles_habitaciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('niveles_id');
            $table->integer('categoria_id');
            $table->text('descripcion');
            $table->bigInteger('precio');
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
        Schema::dropIfExists('niveles_habitaciones');
    }
}
