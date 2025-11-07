<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('question_groups', function (Blueprint $table) {
    $table->id();
    $table->string('name');  
    $table->enum('type', ['PU', 'PSI'])->default('PU'); // ✅ fleksibel
    $table->text('video_tutorial')->nullable();
    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('question_groups');
    }
};
