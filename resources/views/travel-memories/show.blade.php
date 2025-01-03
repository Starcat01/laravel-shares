@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>{{ $travelMemory->title }}</h2>
            <p>
                <strong>Location:</strong> {{ $travelMemory->location ?? 'Unknown' }} |
                <strong>Date:</strong> {{ $travelMemory->date ?? 'Not provided' }}
            </p>
        </div>
        <div class="card-body">
            <!-- Description -->
            <p>{{ $travelMemory->description }}</p>
            <!-- Display Photos -->
            @if(!empty($travelMemory->photos) && is_array($travelMemory->photos))
                <div class="mb-4">
                    <h5>Photos:</h5>
                    @foreach($travelMemory->photos as $photo)
                        <img src="{{ asset('storage/' . $photo) }}" alt="Photo" class="img-thumbnail mb-2" width="150">
                    @endforeach
                </div>
            @endif
            <!-- Display Videos -->
            @if(!empty($travelMemory->videos) && is_array($travelMemory->videos))
                <div class="mb-4">
                    <h5>Videos:</h5>
                    @foreach($travelMemory->videos as $video)
                        <video controls class="d-block mb-3" width="300">
                            <source src="{{ asset('storage/' . $video) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @endforeach
                </div>
            @endif
            <!-- Souvenirs -->
            @if(!empty($travelMemory->souvenirs))
                <div class="mb-4">
                    <h5>Souvenirs:</h5>
                    <p>{{ $travelMemory->souvenirs }}</p>
                </div>
            @endif
            <!-- Travel Journal -->
            @if(!empty($travelMemory->journal))
                <div class="mb-4">
                    <h5>Travel Journal:</h5>
                    <p>{{ $travelMemory->journal }}</p>
                </div>
            @endif
            <!-- Ticket Details -->
            @if(!empty($travelMemory->ticket_details))
                <div class="mb-4">
                    <h5>Ticket Details:</h5>
                    <p>{{ $travelMemory->ticket_details }}</p>
                </div>
            @endif
            <!-- Map URL -->
            @if(!empty($travelMemory->map_url))
                <div class="mb-4">
                    <h5>Map:</h5>
                    <a href="{{ $travelMemory->map_url }}" target="_blank" class="btn btn-link">View Map</a>
                </div>
            @endif
            <!-- Shared Recipes -->
            @if(!empty($travelMemory->shared_recipes))
                <div class="mb-4">
                    <h5>Shared Recipes:</h5>
                    <p>{{ $travelMemory->shared_recipes }}</p>
                </div>
            @endif
        </div>
        <div class="card-footer">
            <a href="{{ route('travel-memories.edit', $travelMemory->id) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('travel-memories.destroy', $travelMemory->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this memory?');">Delete</button>
            </form>
            <a href="{{ route('travel-memories.index') }}" class="btn btn-secondary">Back to Memories</a>
        </div>
    </div>
</div>
@endsection
