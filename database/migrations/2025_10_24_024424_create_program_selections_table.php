<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('program_selections', function (Blueprint $table) {
            $table->id('id_selection');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('id_program_1')->nullable();
            $table->unsignedBigInteger('id_program_2')->nullable();
            $table->timestamps();

            // relasi ke tabel lain
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_program_1')->references('id_program')->on('study_programs');
            $table->foreign('id_program_2')->references('id_program')->on('study_programs');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_selections');
    }
};
