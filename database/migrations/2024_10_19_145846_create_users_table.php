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

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('username', 20)->unique(); // Pastikan username unik
            $table->string('password', 100);
            $table->string('role', 15);
            $table->unsignedInteger('posyandu_id')->nullable();
            $table->foreign('posyandu_id')->references('id')->on('posyandu');

            // Menambahkan kolom timestamp otomatis dengan default current timestamp
            $table->timestamps(); // Menggantikan created_at dan updated_at secara otomatis
            $table->softDeletes(); // Menggantikan deleted_at dengan SoftDeletes

            // Kolom audit
            $table->integer('created_by');
            $table->integer('updated_by')->nullable(); // Updated_by sebaiknya nullable

            // Menambahkan kolom remember_token untuk fitur "Ingat saya"
            $table->rememberToken(); // Menambahkan kolom remember_token
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
