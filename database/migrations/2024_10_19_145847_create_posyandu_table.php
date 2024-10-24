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

        Schema::create('posyandu', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 20);

            // Menambahkan timestamps untuk created_at dan updated_at secara otomatis
            $table->timestamps();

            // Kolom audit
            $table->integer('created_by');
            $table->integer('updated_by')->nullable(); // Updated_by sebaiknya nullable
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posyandu');
    }
};
