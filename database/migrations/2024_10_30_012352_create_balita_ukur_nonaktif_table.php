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

        Schema::create('balita_ukur_nonaktif', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('balita_nonaktif_id');
            $table->foreign('balita_nonaktif_id')->references('id')->on('balita_nonaktif')->onDelete('cascade');
            $table->date('tgl_ukur');
            $table->string('umur_ukur', 30);
            $table->double('bb');
            $table->double('tb');
            $table->double('lk')->nullable();
            $table->string('cara_ukur', 10);
            $table->string('status_bb_u', 30);
            $table->double('zscore_bb_u');
            $table->string('status_tb_u', 30);
            $table->double('zscore_tb_u');
            $table->string('status_bb_tb', 30);
            $table->double('zscore_bb_tb');
            $table->string('status_imt_u', 30);
            $table->double('zscore_imt_u');
            $table->string('status_lk_u', 30)->nullable();
            $table->double('zscore_lk_u')->nullable();
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
        Schema::dropIfExists('balita_ukur_nonaktif');
    }
};
