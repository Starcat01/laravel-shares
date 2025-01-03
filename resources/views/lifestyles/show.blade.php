@extends('layouts.app')

@section('title', 'Lifestyle Profile Details')

@section('content')
<div class="container">
    <h4 class="mt-4">{{ $lifestyle->name }}</h4>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Description -->
    <div class="mb-3">
        <h5>Description</h5>
        <p>{{ $lifestyle->description ?? 'No description available.' }}</p>
    </div>

    <!-- Dynamic JSON Fields -->
    @php
        $fields = [
            'daily_routine' => 'Daily Routine',
            'health_wellness' => 'Health & Wellness',
            'social_life' => 'Social Life',
            'cultural_practices' => 'Cultural Practices',
            'financial_habits' => 'Financial Habits',
            'travel_exploration' => 'Travel & Exploration',
            'fashion_style' => 'Fashion Style',
            'entertainment_choices' => 'Entertainment Choices',
            'technology_gadgets' => 'Technology & Gadgets',
            'eco_practices' => 'Eco Practices',
            'goals_aspirations' => 'Goals & Aspirations',
            'unique_quirks' => 'Unique Quirks',
        ];
    @endphp

    @foreach($fields as $key => $label)
        <div class="mb-3">
            <h5>{{ $label }}</h5>
            @if(!empty($lifestyle->{$key}) && is_array($lifestyle->{$key}))
                <ul>
                    @foreach($lifestyle->{$key} as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted">No {{ strtolower($label) }} specified.</p>
            @endif
        </div>
    @endforeach

    <!-- Static Fields -->
    <div class="mb-3">
        <h5>Occupation</h5>
        <p>{{ $lifestyle->occupation ?? 'Not specified.' }}</p>

        <h5>Work Environment</h5>
        <p>{{ $lifestyle->work_environment ?? 'Not specified.' }}</p>
    </div>

    <div class="mb-3">
        <h5>Religion</h5>
        <p>{{ $lifestyle->religion ?? 'Not specified.' }}</p>

        <h5>Residence Type</h5>
        <p>{{ $lifestyle->residence_type ?? 'Not specified.' }}</p>
    </div>

    <!-- Edit and Back Buttons -->
    <div class="mt-4">
        <a href="{{ route('lifestyles.edit', $lifestyle->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit Profile
        </a>
        <a href="{{ route('lifestyles.index') }}" class="btn btn-secondary">Back to Profiles</a>
    </div>
</div>
@endsection

