<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orangtua', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_kk', 16);
            $table->string('name_ibu', 50);
            $table->string('nik_ibu', 16)->unique()->nullable(); // Membuat nik unik
            $table->string('name_ayah', 50);
            $table->string('nik_ayah', 16)->unique()->nullable(); // Membuat nik unik
            $table->string('telp', 13)->nullable();
            $table->string('alamat', 50);
            $table->unsignedInteger('rt_id');
            $table->foreign('rt_id')->references('id')->on('rt')->onDelete('cascade');
            $table->unsignedInteger('dusun_id');
            $table->foreign('dusun_id')->references('id')->on('dusun')->onDelete('cascade');
            $table->string('desa', 20);
            $table->string('kecamatan', 20);
            $table->string('kabupaten', 20);
            $table->string('provinsi', 20);
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps(); // Menambahkan created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orangtua');
    }
};
