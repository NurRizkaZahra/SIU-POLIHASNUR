<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exam', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Foreign key ke users
            $table->unsignedBigInteger('exam_schedule_id')->nullable(); // Foreign key ke exam_schedules
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])
                  ->default('pending');
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
            
            $table->foreign('exam_schedule_id')
                  ->references('id')
                  ->on('exam_schedules')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam');
    }
};