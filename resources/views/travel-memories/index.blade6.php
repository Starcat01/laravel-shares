@extends('layouts.app')
@section('content')
<div class="container">
    <h4>My Travel Memories</h4>
    <a href="{{ route('travel-memories.create') }}" class="btn btn-primary mb-3">Create New Memory</a>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if($travelMemories->isEmpty())
        <p class="text-muted">You have no travel memories yet. Start by creating one!</p>
    @else
        @foreach($travelMemories as $memory)
            <div class="card mb-4">
                <div class="card-header">
                    <h4>
                        <a href="{{ route('travel-memories.show', $memory->id) }}">{{ $memory->title }}</a>
                    </h4>
                    <p>
                        <strong>Location:</strong> {{ $memory->location ?? 'Unknown' }} |
                        <strong>Date:</strong> {{ $memory->date ?? 'Not provided' }}
                    </p>
                </div>
                <div class="card-body">
                    <p>{{ $memory->description }}</p>
                    
                    <!-- Display Map link -->
                    @if(!empty($memory->map_url))
                        <div class="mb-3">
                            <h5>View on Map:</h5>
                            <a href="{{ $memory->map_url }}" target="_blank" class="btn btn-info">Open Map</a>
                        </div>
                    @endif
                    
                    <!-- Display photos -->
                    @if(!empty($memory->photos) && is_array($memory->photos))
                        <div class="mb-3">
                            <h5>Photos:</h5>
                            @foreach($memory->photos as $photo)
                                <img src="{{ asset('storage/' . $photo) }}" alt="Photo" class="img-thumbnail" width="150">
                            @endforeach
                        </div>
                    @endif
                    
                    <!-- Display videos -->
                    @if(!empty($memory->videos) && is_array($memory->videos))
                        <div class="mb-3">
                            <h5>Videos:</h5>
                            @foreach($memory->videos as $video)
                                <video controls class="d-block mb-2" width="300">
                                    <source src="{{ asset('storage/' . $video) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @endforeach
                        </div>
                    @endif
                    
                    <div class="mt-3 d-flex justify-content-end">
                        <a href="{{ route('travel-memories.edit', $memory->id) }}" class="btn btn-warning me-2">Edit Memory</a>
                        <a href="{{ route('travel-memories.showMediaForDeletion', $memory->id) }}" class="btn btn-primary me-2">Delete Photos/Videos</a>
                        <form action="{{ route('travel-memories.destroy', $memory->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this memory?');">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
