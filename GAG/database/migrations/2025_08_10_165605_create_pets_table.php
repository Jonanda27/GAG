<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */public function up()
{
    Schema::create('pets', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->decimal('harga', 10, 2);
        $table->integer('stok');
        $table->binary('gambar');
        $table->timestamps();
    });
    DB::statement('ALTER TABLE pets MODIFY gambar LONGBLOB');
}



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pets');
    }
}
