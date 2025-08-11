<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
      public function up(): void
    {
        Schema::create('testis', function (Blueprint $table) {
            $table->id();
            $table->binary('gambar'); // Menyimpan path gambar
            $table->timestamps();
        });
        DB::statement('ALTER TABLE testis MODIFY gambar LONGBLOB');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('testis');
    }
}
