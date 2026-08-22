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
        Schema::create('visit_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('destination_id')
                ->constrained('tourist_destinations')
                ->cascadeOnDelete();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->date('planned_date');
            $table->string('group_size')->nullable(); // solo, couple, family, large
            $table->text('notes')->nullable();
            $table->enum('status', ['planned', 'visited', 'cancelled'])->default('planned');
            $table->timestamps();

            // One active plan per tourist per destination
            $table->unique(['destination_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_plans');
    }
};
