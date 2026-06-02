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
        Schema::table('pesertas', function (Blueprint $table) {
            $table->unsignedBigInteger('id_jabatan_instansi')->nullable();
            $table->foreign('id_jabatan_instansi')->references('id')->on('instansi_x_jabatans')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesertas', function (Blueprint $table) {
            $table->dropForeign(['id_jabatan_instansi']);
            $table->dropColumn('id_jabatan_instansi');
        });
    }
};
