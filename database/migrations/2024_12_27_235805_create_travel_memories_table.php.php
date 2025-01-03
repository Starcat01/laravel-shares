<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateTravelMemoriesTable extends Migration
{
    public function up()
    {
        Schema::create('travel_memories', function (Blueprint $table) {
            $table->id(); // Unique identifier for each travel memory
            $table->unsignedBigInteger('user_id'); // Links the travel memory to the user who created it
            $table->string('title'); // Descriptive title for the travel memory
            $table->text('description')->nullable(); // Brief description of the trip or memory
            $table->string('location')->nullable(); // Destination of the trip
            $table->date('date')->nullable(); // Date or time period of the travel
            $table->json('photos')->nullable(); // JSON for storing multiple photo paths
            $table->json('videos')->nullable(); // JSON for storing multiple video paths
            $table->json('souvenirs')->nullable(); // JSON for storing souvenir details
            $table->text('journal')->nullable(); // Travel journal or notes
            $table->json('ticket_details')->nullable(); // JSON for storing ticket or pass details
            $table->string('map_url')->nullable(); // URL for the map location
            $table->text('shared_recipes')->nullable(); // Recipes or cultural notes
            $table->timestamps(); // Timestamps for created_at and updated_at
            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists('travel_memories');
    }
}

