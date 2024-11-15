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
        Schema::create('standar_pertumbuhan_anak_expanded', function (Blueprint $table) {
            $table->string('kategori', 25);
            $table->string('gender', 1);
            $table->decimal('umur_atau_tinggi', 5, 1);
            $table->decimal('L', 10, 5);
            $table->decimal('M', 10, 5);
            $table->decimal('S', 10, 5);
            $table->decimal('sd4neg', 6, 3);
            $table->decimal('sd3neg', 6, 3);
            $table->decimal('sd2neg', 6, 3);
            $table->decimal('sd1neg', 6, 3);
            $table->decimal('median', 6, 3);
            $table->decimal('sd1', 6, 3);
            $table->decimal('sd2', 6, 3);
            $table->decimal('sd3', 6, 3);
            $table->decimal('sd4', 6, 3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('standar_pertumbuhan_anak_expanded');
    }
};
