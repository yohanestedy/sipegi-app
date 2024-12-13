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
        Schema::disableForeignKeyConstraints();

        Schema::create('balita', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('nik', 16)->nullable()->unique(); // Membuat nik unik
            $table->date('tgl_lahir');
            $table->string('gender', 1);
            $table->string('bpjs', 15);
            $table->unsignedInteger('orangtua_id');
            $table->foreign('orangtua_id')->references('id')->on('orangtua')->onDelete('cascade');
            $table->unsignedInteger('posyandu_id');
            $table->foreign('posyandu_id')->references('id')->on('posyandu')->onDelete('cascade');
            $table->integer('family_order');
            $table->float('bb_lahir');
            $table->float('tb_lahir');
            $table->string('status', 20);
            $table->date('tgl_aktif');
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balita');
    }
};
