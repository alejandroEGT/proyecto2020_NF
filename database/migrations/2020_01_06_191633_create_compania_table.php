<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compania', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('nombre');
            $table->text('razon_social');
            $table->text('ubicacion');
            $table->string('rol')->nullable();
            $table->text('logo')->nullable();
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
        Schema::dropIfExists('compania');
    }
}
