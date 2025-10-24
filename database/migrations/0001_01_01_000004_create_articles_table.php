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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->string('title', 150);
            $table->string('slug', 150)->unique();
            $table->text('content');
            $table->string('image_path')->nullable();
            $table->enum('status', ['Draf', 'Terbit', 'Arsip'])->default('Draf');
            $table->bigInteger('views')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
