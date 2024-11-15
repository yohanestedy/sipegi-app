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
        Schema::create('standar_pertumbuhan_anak', function (Blueprint $table) {
            $table->string('kategori', 25);
            $table->string('gender', 1);
            $table->decimal('umur_atau_tinggi', 5, 1);
            $table->decimal('L', 10, 5);
            $table->decimal('M', 10, 5);
            $table->decimal('S', 10, 5);
            $table->decimal('sd3neg', 5, 1);
            $table->decimal('sd2neg', 5, 1);
            $table->decimal('sd1neg', 5, 1);
            $table->decimal('median', 5, 1);
            $table->decimal('sd1', 5, 1);
            $table->decimal('sd2', 5, 1);
            $table->decimal('sd3', 5, 1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('standar_pertumbuhan_anak');
    }
};
