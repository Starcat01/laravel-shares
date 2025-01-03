<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // Ensure the User model is imported

class LifestyleProfile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'daily_routine',
        'occupation',
        'work_environment',
        'health_wellness',
        'social_life',
        'religion',
        'cultural_practices',
        'residence_type',
        'financial_habits',
        'travel_exploration',
        'fashion_style',
        'entertainment_choices',
        'technology_gadgets',
        'eco_practices',
        'goals_aspirations',
        'unique_quirks',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'daily_routine' => 'array',
        'health_wellness' => 'array',
        'social_life' => 'array',
        'cultural_practices' => 'array',
        'financial_habits' => 'array',
        'travel_exploration' => 'array',
        'fashion_style' => 'array',
        'entertainment_choices' => 'array',
        'technology_gadgets' => 'array',
        'eco_practices' => 'array',
        'goals_aspirations' => 'array',
        'unique_quirks' => 'array',
    ];

    /**
     * Define the relationship with the User model.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}