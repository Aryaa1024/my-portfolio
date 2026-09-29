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
        Schema::create('qualifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('board_or_university')->nullable();
            $table->string('college')->nullable();
            $table->string('course_name')->nullable();
            $table->string('course_start')->nullable();
            $table->string('course_end')->nullable();
            $table->enum('type',['percentage','grade','cgpa'])->nullable();
            $table->string('type_value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qualifications');
    }
};
