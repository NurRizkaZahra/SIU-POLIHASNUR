<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();

            // Foreign key ke users
            $table->unsignedBigInteger('user_id');

            // Foreign key ke exam_schedules
            $table->unsignedBigInteger('exam_schedule_id')->nullable();

            /**
             * Status ujian:
             * - pending    : menunggu verifikasi
             * - approved   : sudah diverifikasi admin
             * - in_progress: sedang berlangsung
             * - completed  : selesai
             * - rejected   : ditolak admin
             */
            $table->enum('status', [
                'pending',
                'approved',
                'rejected',
                'in_progress',
                'completed'
            ])->default('pending');

            // Waktu ujian
            $table->dateTime('started_at')->nullable();
            $table->dateTime('finished_at')->nullable();

            // Nilai ujian
            $table->integer('score')->nullable();

            $table->timestamps();

            // ------------------ RELASI ------------------

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
        Schema::dropIfExists('exams');
    }
};
