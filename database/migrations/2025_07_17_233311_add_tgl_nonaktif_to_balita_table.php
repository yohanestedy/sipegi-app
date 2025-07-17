<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('balita', function (Blueprint $table) {
            $table->date('tgl_nonaktif')->nullable()->after('tgl_aktif');
        });
    }

    public function down()
    {
        Schema::table('balita', function (Blueprint $table) {
            $table->dropColumn('tgl_nonaktif');
        });
    }
};
