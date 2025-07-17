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
        Schema::table('balita', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('name');
        });

        Schema::table('balita_nonaktif', function (Blueprint $table) {
            $table->boolean('is_active')->default(false)->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('balita', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });

        Schema::table('balita_nonaktif', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
};
