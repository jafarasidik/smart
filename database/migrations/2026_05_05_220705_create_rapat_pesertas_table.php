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
        Schema::create('rapat_pesertas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_rapat')->nullable();
            $table->foreign('id_rapat')->references('id')->on('rapats')->nullOnDelete();
            $table->unsignedBigInteger('id_peserta')->nullable();
            $table->foreign('id_peserta')->references('id')->on('pesertas')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rapat_pesertas');
    }
};
