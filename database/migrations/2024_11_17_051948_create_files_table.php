<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('file_name'); // Name of the file
            $table->string('file_path'); // Path to file storage
            $table->string('file_link')->nullable(); // For storing the file link
             
            $table->unsignedBigInteger('user_id')->nullable(); // If you want to associate files with users
            $table->unsignedBigInteger('portfolio_id')->nullable(); // Add portfolio_id column
            
            $table->timestamps(); // Created at & Updated at timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('files');
    }
}