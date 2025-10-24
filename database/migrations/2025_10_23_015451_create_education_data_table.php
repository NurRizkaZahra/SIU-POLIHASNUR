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
        Schema::create('education_data', function (Blueprint $table) {
            $table->id('id_education');
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->string('school_name');
            $table->string('school_address');
            $table->string('major');
            $table->string('nisn');
            $table->string('school_code');
            $table->string('year_of_entry');
            $table->string('achievement')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('education_data');
    }
};
