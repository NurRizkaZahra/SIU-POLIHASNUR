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
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger('id_program_1');
    $table->unsignedBigInteger('id_program_2');

    // Foreign key ke tabel programs
    $table->foreign('id_program_1')
          ->references('id_program')
          ->on('study_programs')
          ->onDelete('cascade');

    $table->foreign('id_program_2')
          ->references('id_program')
          ->on('study_programs')
          ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_selections');
    }
};
