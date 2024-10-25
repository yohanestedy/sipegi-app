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
        Schema::create('rt', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('dusun_id');
            $table->foreign('dusun_id')->references('id')->on('dusun')->onDelete('cascade');
            $table->string('rt', 3);
            $table->timestamps(); // Menambahkan created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rt');
    }
};
