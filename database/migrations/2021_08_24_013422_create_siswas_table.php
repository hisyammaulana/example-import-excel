<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode')->nullable();
            $table->string('nik')->nullable();
            $table->string('nis')->nullable();
            $table->string('nisn')->nullable();
            $table->string('nama');
            $table->enum('jenkel', ['l', 'p']);
            $table->string('agama');
            $table->string('file')->nullable()->default('images/default.png');
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->text('alamat')->nullable();
            $table->string('lintang')->nullable();
            $table->string('bujur')->nullable();
            $table->string('password');
            $table->tinyInteger('anak_ke')->nullable();
            $table->string('status_keluarga')->nullable();
            $table->string('kls_diterima')->nullable();
            $table->date('tgl_diterima')->nullable();
            $table->string('no_ijazah')->nullable();
            $table->string('th_ijazah')->nullable();
            $table->string('no_skhun')->nullable();
            $table->string('th_skhun')->nullable();
            $table->string('nama_ayah')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->string('nama_wali')->nullable();
            $table->string('alamat_wali')->nullable();
            $table->string('telp_wali')->nullable();
            $table->string('pekerjaan_wali')->nullable();
            $table->string('first_password');
            $table->longText('fcm_token')->nullable();
            $table->string('sosial');
            $table->string('tahun_angkatan')->nullable();
            $table->dateTimeTz('before_last_login')->nullable();
            $table->dateTimeTz('last_login')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->bigInteger('id_sekolah')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siswas');
    }
}
