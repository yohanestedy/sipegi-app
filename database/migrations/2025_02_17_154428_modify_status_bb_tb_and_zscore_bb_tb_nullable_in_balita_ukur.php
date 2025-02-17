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
        Schema::table('balita_ukur', function (Blueprint $table) {
            $table->string('status_bb_tb', 30)->nullable()->change();
            $table->double('zscore_bb_tb')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('balita_ukur', function (Blueprint $table) {
            $table->string('status_bb_tb', 30)->nullable(false)->change();
            $table->double('zscore_bb_tb')->nullable(false)->change();
        });
    }
};
