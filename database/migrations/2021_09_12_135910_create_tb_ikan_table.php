<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbIkanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_ikan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ikan');
            $table->date('tgl');
            $table->integer('harga_awal');
            $table->string('gambar_ikan');
            $table->text('deskripsi_ikan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_ikan', function (Blueprint $table) {
            Schema::dropIfExists('tb_ikan');
        });
    }
}
