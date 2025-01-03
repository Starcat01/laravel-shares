<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    // Fillable properties to allow mass assignment
    protected $fillable = [
        'title',
        'description',
        'laravel_snippet',
        'link',
        'user_id',
        'category_id', // Add category_id for mass assignment
    ];

    /**
     * Define relationship with comments.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Define relationship with categories.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Define relationship: a portfolio belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
