@extends('layouts.app')

@section('title', 'Edit Lifestyle Profile')

@section('content')
<div class="container">
    <h4 class="mt-4">Edit Lifestyle Profile</h4>

    <!-- Display Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Lifestyle Profile Edit Form -->
    <form action="{{ route('lifestyles.update', $lifestyle->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label for="name" class="form-label">Profile Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $lifestyle->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $lifestyle->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="daily_routine" class="form-label">Daily Routine</label>
            <input type="text" class="form-control" id="daily_routine" name="daily_routine[]" placeholder="E.g., Morning run, Yoga" value="{{ old('daily_routine.0', $lifestyle->daily_routine[0] ?? '') }}">
            <small class="text-muted">Separate multiple routines by adding new fields.</small>
        </div>

        <div class="mb-3">
            <label for="occupation" class="form-label">Occupation</label>
            <input type="text" class="form-control" id="occupation" name="occupation" value="{{ old('occupation', $lifestyle->occupation) }}">
        </div>

        <div class="mb-3">
            <label for="work_environment" class="form-label">Work Environment</label>
            <input type="text" class="form-control" id="work_environment" name="work_environment" value="{{ old('work_environment', $lifestyle->work_environment) }}">
        </div>

        <div class="mb-3">
            <label for="health_wellness" class="form-label">Health & Wellness</label>
            <input type="text" class="form-control" id="health_wellness" name="health_wellness[]" placeholder="E.g., Yoga, Vegan Diet" value="{{ old('health_wellness.0', $lifestyle->health_wellness[0] ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="social_life" class="form-label">Social Life</label>
            <input type="text" class="form-control" id="social_life" name="social_life[]" placeholder="E.g., Hiking with friends, Movie nights" value="{{ old('social_life.0', $lifestyle->social_life[0] ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="religion" class="form-label">Religion</label>
            <input type="text" class="form-control" id="religion" name="religion" value="{{ old('religion', $lifestyle->religion) }}">
        </div>

        <div class="mb-3">
            <label for="cultural_practices" class="form-label">Cultural Practices</label>
            <input type="text" class="form-control" id="cultural_practices" name="cultural_practices[]" placeholder="E.g., Traditional Festivals" value="{{ old('cultural_practices.0', $lifestyle->cultural_practices[0] ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="residence_type" class="form-label">Residence Type</label>
            <input type="text" class="form-control" id="residence_type" name="residence_type" value="{{ old('residence_type', $lifestyle->residence_type) }}">
        </div>

        <div class="mb-3">
            <label for="financial_habits" class="form-label">Financial Habits</label>
            <input type="text" class="form-control" id="financial_habits" name="financial_habits[]" placeholder="E.g., Savings, Investments" value="{{ old('financial_habits.0', $lifestyle->financial_habits[0] ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="travel_exploration" class="form-label">Travel & Exploration</label>
            <input type="text" class="form-control" id="travel_exploration" name="travel_exploration[]" placeholder="E.g., Backpacking, Luxury Travel" value="{{ old('travel_exploration.0', $lifestyle->travel_exploration[0] ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="fashion_style" class="form-label">Fashion Style</label>
            <input type="text" class="form-control" id="fashion_style" name="fashion_style[]" placeholder="E.g., Casual, Formal" value="{{ old('fashion_style.0', $lifestyle->fashion_style[0] ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="entertainment_choices" class="form-label">Entertainment Choices</label>
            <input type="text" class="form-control" id="entertainment_choices" name="entertainment_choices[]" placeholder="E.g., Movies, Gaming" value="{{ old('entertainment_choices.0', $lifestyle->entertainment_choices[0] ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="technology_gadgets" class="form-label">Technology & Gadgets</label>
            <input type="text" class="form-control" id="technology_gadgets" name="technology_gadgets[]" placeholder="E.g., Smartphones, Laptops" value="{{ old('technology_gadgets.0', $lifestyle->technology_gadgets[0] ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="eco_practices" class="form-label">Eco Practices</label>
            <input type="text" class="form-control" id="eco_practices" name="eco_practices[]" placeholder="E.g., Recycling, Composting" value="{{ old('eco_practices.0', $lifestyle->eco_practices[0] ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="goals_aspirations" class="form-label">Goals & Aspirations</label>
            <input type="text" class="form-control" id="goals_aspirations" name="goals_aspirations[]" placeholder="E.g., Fitness Goals, Career Goals" value="{{ old('goals_aspirations.0', $lifestyle->goals_aspirations[0] ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="unique_quirks" class="form-label">Unique Quirks</label>
            <input type="text" class="form-control" id="unique_quirks" name="unique_quirks[]" placeholder="E.g., Collecting Stamps, Singing" value="{{ old('unique_quirks.0', $lifestyle->unique_quirks[0] ?? '') }}">
        </div>

        <button type="submit" class="btn btn-primary">Update Profile</button>
        <a href="{{ route('lifestyles.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection



