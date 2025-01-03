<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelMemory extends Model
{
    use HasFactory;

    // Specify the attributes that are mass assignable
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'location',
        'date',
        'photos',
        'videos',
        'souvenirs',
        'journal',
        'ticket_details',
        'map_url',
        'shared_recipes',
    ];

    // Cast JSON fields to arrays
    protected $casts = [
        'photos' => 'array',
        'videos' => 'array',
        'souvenirs' => 'array',
        'ticket_details' => 'array',
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
