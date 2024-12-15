<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRenstraKadisTable extends Migration
{
    public function up()
    {
        Schema::create('renstra_kadis', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_agenda')->unique();
            $table->string('nama_agenda_renstra');
            $table->text('deskripsi_uraian_renstra');
            $table->string('disposisi_diteruskan');
            $table->date('tanggal_mulai');
            $table->date('tanggal_akhir');
            $table->string('status');
            $table->boolean('is_terlaksana')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('renstra_kadis');
    }
}