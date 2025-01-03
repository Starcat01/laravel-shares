<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLifestyleProfilesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('lifestyle_profiles', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('user_id'); // Links the lifestyle profile to a user
            $table->string('name'); // Name of the lifestyle profile
            $table->text('description')->nullable(); // Brief description of the lifestyle
            $table->json('daily_routine')->nullable(); // JSON for daily habits or routine
            $table->string('occupation')->nullable(); // User's job or profession
            $table->string('work_environment')->nullable(); // Work style (e.g., remote, office)
            $table->json('health_wellness')->nullable(); // JSON for health-related habits
            $table->json('social_life')->nullable(); // JSON for social interactions or hobbies
            $table->string('religion')->nullable(); // Religious beliefs or practices
            $table->json('cultural_practices')->nullable(); // JSON for cultural or spiritual practices
            $table->string('residence_type')->nullable(); // Type of residence (urban, rural, etc.)
            $table->json('financial_habits')->nullable(); // JSON for financial preferences or habits
            $table->json('travel_exploration')->nullable(); // JSON for travel interests or experiences
            $table->json('fashion_style')->nullable(); // JSON for clothing and style preferences
            $table->json('entertainment_choices')->nullable(); // JSON for entertainment habits
            $table->json('technology_gadgets')->nullable(); // JSON for tech usage or devices
            $table->json('eco_practices')->nullable(); // JSON for eco-friendly practices
            $table->json('goals_aspirations')->nullable(); // JSON for personal or lifestyle goals
            $table->json('unique_quirks')->nullable(); // JSON for unique habits or preferences
            $table->timestamps(); // Timestamps for created_at and updated_at
            
            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('lifestyle_profiles');
    }
}