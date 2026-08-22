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
        Schema::create('destination_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('destination_id')
                ->constrained('tourist_destinations')
                ->cascadeOnDelete();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->unsignedTinyInteger('rating'); // 1 to 5 stars
            $table->string('title')->nullable();
            $table->text('comment')->nullable();
            $table->date('visit_date')->nullable();
            $table->timestamps();

            // One review per tourist per destination (can update/edit anytime)
            $table->unique(['destination_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destination_reviews');
    }
};
