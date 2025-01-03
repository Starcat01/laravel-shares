<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortfoliosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id'); //the owner of the post
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); 
            $table->string('title');
            $table->text('description');
            $table->text('laravel_snippet');
            $table->string('link')->nullable();
            $table->string('file_link')->nullable(); // Added this line for file link
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio');
    }
};
