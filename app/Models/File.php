<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    // Specify which attributes are mass assignable
    protected $fillable = [
        'file_name',
        'file_path', // Add this if you are saving the path as well
        'portfolio_id', // If you're linking the file to a portfolio
        'user_id',  // If applicable
        // Add other attributes that may need mass assignment
    ];
}