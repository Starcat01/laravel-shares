<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Profile extends Model
{
    use HasFactory;

    // Specify the table associated with the model (if different from 'profiles')
    protected $table = 'profiles';
    
    // Define the fillable properties
    protected $fillable = [
        'user_id',
        'bio',
        'avatar',
    ];

    // Define the relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Optional: Define an accessor for the avatar
    public function getAvatarUrlAttribute()
    {
        return asset('storage/' . $this->avatar);
    }

    // If you need to fetch a profile for the currently authenticated user
    public static function current()
    {
        return self::where('user_id', Auth::id())->first();
    }
}