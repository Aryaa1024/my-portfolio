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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('title')->nullable();
            $table->string('slug')->unique();
            $table->string('excerpt')->nullable();
            $table->longText('description')->nullable(); // taken by rich-contents text-editors
            $table->string('featured_image')->nullable(); //single image
            $table->string('keywords')->nullable();
            $table->enum('status',['draft','published','archived'])->default('draft');
            $table->timestamp('published_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
