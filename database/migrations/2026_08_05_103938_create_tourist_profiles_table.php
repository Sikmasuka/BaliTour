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
        Schema::create('tourist_profiles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained()
                ->cascadeOnDelete();

            // Name
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('suffix')->nullable();

            // Personal Information
            $table->enum('gender', [
                'male',
                'female',
                'prefer_not_to_say',
            ])->nullable();

            $table->date('birth_date')->nullable();

            // Contact
            $table->string('mobile_number', 20);

            // Balingasag Local Location
            $table->string('city_municipality')->default('Balingasag');
            $table->string('province')->default('Misamis Oriental');
            $table->string('barangay')->nullable();

            // Profile
            $table->string('profile_photo')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tourist_profiles');
    }
};
