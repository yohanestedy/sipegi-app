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

        Schema::create('balita_ukur', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('balita_id');
            $table->foreign('balita_id')->references('id')->on('balita')->onDelete('cascade');
            $table->date('tgl_ukur');
            $table->integer('umur_ukur');
            $table->float('bb');
            $table->float('tb');
            $table->string('cara_ukur', 10);
            $table->string('bb_per_u', 30);
            $table->float('zs_bb_per_u');
            $table->string('tb_per_u', 30);
            $table->float('zs_tb_per_u');
            $table->string('bb_per_tb', 30);
            $table->float('zs_bb_per_tb');
            $table->string('imt_per_u', 30);
            $table->float('zs_imt_per_u');
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
        Schema::dropIfExists('balita_ukur');
    }
};
