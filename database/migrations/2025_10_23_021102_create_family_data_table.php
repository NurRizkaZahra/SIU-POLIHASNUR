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
        Schema::create('family_data', function (Blueprint $table) {
            $table->id('id_family');
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->string('father_name');
            $table->string('father_job');
            $table->string('mother_name');
            $table->string('mother_job');
            $table->string('parent_income');
            $table->integer('number_of_children');
            $table->integer('child_order');
            $table->text('parent_address');
            $table->string('parent_phone');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_data');
    }
};
