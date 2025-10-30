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
            $table->foreignId('id_program_1')->constrained('study_programs')->onDelete('cascade');
            $table->foreignId('id_program_2')->nullable()->constrained('study_programs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_selections');
    }
};
