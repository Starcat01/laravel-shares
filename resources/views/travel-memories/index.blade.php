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
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="flex-fill me-3">
                            <p>{{ $memory->description }}</p>
                        </div>

                        @if(!empty($memory->map_url))
                            <div>
                                <a href="{{ $memory->map_url }}" target="_blank" class="btn btn-info">View on Map</a>
                            </div>
                        @endif
                    </div>

                    <!-- Display photos -->
                    @if(!empty($memory->photos) && is_array($memory->photos))
                        <div class="mb-3">
                            <h5>Photos:</h5>
                            <div class="row">
                                @foreach($memory->photos as $photo)
                                    <div class="col-md-6 mb-3">
                                        <img src="{{ asset('storage/' . $photo) }}" 
                                            alt="Photo" 
                                            class="img-thumbnail scalable-photo" 
                                            style="width: 100%; height: auto;">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    <!-- Display videos -->
                    @if(!empty($memory->videos) && is_array($memory->videos))
                        <div class="mb-3">
                            <h5>Videos:</h5>
                            <div class="row">
                                @foreach($memory->videos as $video)
                                    <div class="col-md-6 mb-3">
                                        <video controls class="w-100">
                                            <source src="{{ asset('storage/' . $video) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="mt-3 d-flex justify-content-end">
                        <a href="{{ route('travel-memories.edit', $memory->id) }}" class="btn btn-warning me-2">Edit Memory</a>
                        <a href="{{ route('travel-memories.showMediaForDeletion', $memory->id) }}" class="btn btn-primary me-2">Delete Photos/Videos</a>
                        <a href="{{ route('travel-memories.addMedia', $memory->id) }}" class="btn btn-success me-2">Add Photos/Videos</a>
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

<!-- Add JavaScript to handle scaling effect -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const photos = document.querySelectorAll('.scalable-photo');
        photos.forEach(photo => {
            photo.addEventListener('click', () => {
                photo.classList.toggle('scaled');
            });
        });
    });
</script>

<!-- Add CSS for scaling -->
<style>
    .scalable-photo {
        transition: transform 0.3s ease;
        cursor: pointer;
    }

    .scalable-photo.scaled {
        transform: scale(2); /* Scale up */
        z-index: 1000; /* Ensure the photo stays on top */
        position: relative;
    }
</style>
@endsection

