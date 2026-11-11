<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->unique()->constrained('listings')->cascadeOnDelete();
            $table->enum('employment_type', ['full_time', 'part_time', 'contract', 'internship', 'temporary'])->default('full_time');
            $table->enum('workplace_type', ['onsite', 'remote', 'hybrid'])->default('onsite');
            $table->decimal('min_salary', 15, 2)->nullable();
            $table->decimal('max_salary', 15, 2)->nullable();
            $table->string('salary_period', 20)->default('month'); // month, hour, year
            $table->string('experience_level', 50)->nullable(); // entry, mid, senior, executive
            $table->string('company_name', 150)->nullable();
            $table->string('company_logo', 500)->nullable();
            $table->timestamps();
        });

        Schema::create('property_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->unique()->constrained('listings')->cascadeOnDelete();
            $table->enum('purpose', ['sale', 'rent'])->default('sale');
            $table->string('property_type', 50); // house, flat, plot, commercial, room
            $table->decimal('area_size', 10, 2);
            $table->string('area_unit', 20)->default('marla'); // marla, kanal, sq_ft, sq_yard
            $table->unsignedSmallInteger('bedrooms')->nullable();
            $table->unsignedSmallInteger('bathrooms')->nullable();
            $table->json('amenities')->nullable();
            $table->timestamps();
        });

        Schema::create('classified_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->unique()->constrained('listings')->cascadeOnDelete();
            $table->string('sub_category', 100)->nullable();
            $table->enum('condition', ['new', 'like_new', 'used', 'refurbished', 'for_parts'])->default('used');
            $table->string('brand', 100)->nullable();
            $table->string('model', 100)->nullable();
            $table->timestamps();
        });

        Schema::create('vehicle_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->unique()->constrained('listings')->cascadeOnDelete();
            $table->string('make', 100);
            $table->string('model', 100);
            $table->string('variant', 100)->nullable();
            $table->unsignedSmallInteger('year');
            $table->unsignedInteger('mileage'); // in km
            $table->enum('transmission', ['manual', 'automatic'])->default('manual');
            $table->enum('fuel_type', ['petrol', 'diesel', 'cng', 'hybrid', 'electric'])->default('petrol');
            $table->unsignedSmallInteger('engine_capacity')->nullable(); // cc
            $table->string('body_type', 50)->nullable(); // sedan, suv, hatchback, bike, commercial
            $table->enum('assembly', ['local', 'imported'])->default('local');
            $table->timestamps();

            $table->index(['make', 'model', 'year']);
        });

        Schema::create('matrimonial_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->unique()->constrained('listings')->cascadeOnDelete();
            $table->enum('profile_for', ['self', 'son', 'daughter', 'brother', 'sister', 'client'])->default('self');
            $table->enum('gender', ['male', 'female']);
            $table->unsignedTinyInteger('age');
            $table->enum('marital_status', ['single', 'divorced', 'widowed', 'separated'])->default('single');
            $table->unsignedSmallInteger('height_cm')->nullable();
            $table->string('religion', 50)->default('Islam');
            $table->string('sect', 50)->nullable();
            $table->string('caste_or_clan', 100)->nullable();
            $table->string('education', 150)->nullable();
            $table->string('profession', 150)->nullable();
            $table->string('monthly_income', 100)->nullable();
            $table->text('family_details')->nullable();
            $table->enum('privacy_level', ['public', 'verified_only', 'on_request'])->default('verified_only');
            $table->timestamps();
        });

        Schema::create('matrimonial_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('matrimonial_profile_id')->unique()->constrained('matrimonial_profiles')->cascadeOnDelete();
            $table->unsignedTinyInteger('min_age')->nullable();
            $table->unsignedTinyInteger('max_age')->nullable();
            $table->string('preferred_city', 100)->nullable();
            $table->string('preferred_education', 150)->nullable();
            $table->string('preferred_profession', 150)->nullable();
            $table->text('additional_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matrimonial_preferences');
        Schema::dropIfExists('matrimonial_profiles');
        Schema::dropIfExists('vehicle_details');
        Schema::dropIfExists('classified_details');
        Schema::dropIfExists('property_details');
        Schema::dropIfExists('job_details');
    }
};

