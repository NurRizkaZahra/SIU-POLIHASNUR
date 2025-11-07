<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->text('question_text');
            $table->json('answer_choices'); // JSON untuk pilihan jawaban A–E
            $table->string('correct_answer'); // Simpan A/B/C/D/E
            $table->integer('score')->default(1);

            // ✅ Untuk PU boleh null (tanpa grup)
            $table->foreignId('question_group_id')->nullable()
                  ->constrained('question_groups')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
