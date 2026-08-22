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
        Schema::create('destination_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('destination_id')
                ->constrained('tourist_destinations')
                ->cascadeOnDelete();
            $table->foreignId('uploaded_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->enum('type', ['image', 'video'])->default('image');
            $table->enum('source', ['upload', 'youtube', 'vimeo'])->default('upload');
            $table->string('file_path')->nullable();
            $table->string('embed_url')->nullable();
            $table->string('thumbnail_path')->nullable();
            $table->string('title')->nullable();
            $table->string('alt_text')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['destination_id', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destination_media');
    }
};
