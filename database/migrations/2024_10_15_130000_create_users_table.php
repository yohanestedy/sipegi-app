<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // id (auto-increment, primary key)
            $table->string('name', 50); // name (varchar 50)
            $table->string('role', 15); // role (varchar 15)
            $table->string('email', 50)->unique(); // email (varchar 50, unique)
            $table->string('password', 255); // password (varchar 255)
            $table->timestamps(); // created_at and updated_at (timestamp)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
