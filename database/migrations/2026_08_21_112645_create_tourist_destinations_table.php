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
        Schema::create('tourist_destinations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category')->default('other'); // cafe, hotel, boulevard, seashore, memory_square, school, gym, falls_nature, church_heritage, market, other
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('address');
            $table->string('city_municipality')->default('Balingasag');
            $table->string('province')->default('Misamis Oriental');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('cover_image')->nullable();
            $table->time('opening_time')->nullable();
            $table->time('closing_time')->nullable();
            $table->decimal('entrance_fee', 10, 2)->default(0.00);
            $table->string('contact_number')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('website_url')->nullable();
            $table->boolean('is_published')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('category');
            $table->index('is_published');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tourist_destinations');
    }
};
