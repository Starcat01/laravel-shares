@extends('layouts.app')
@section('content')
<div class="container">
    <h4>Manage Media for "{{ $travelMemory->title }}"</h4>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <form action="{{ route('travel-memories.deleteMedia', $travelMemory->id) }}" method="POST">
        @csrf
        <div class="row">
            <!-- Display Photos -->
            @if(!empty($travelMemory->photos))
                <h3>Photos</h3>
                @foreach ($travelMemory->photos as $photo)
                    <div class="col-md-3">
                        <div class="card">
                            <img src="{{ asset('storage/' . $photo) }}" class="card-img-top" alt="Photo">
                            <div class="card-body">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="media_to_delete[]" value="{{ $photo }}" id="photo-{{ $loop->index }}">
                                    <label class="form-check-label" for="photo-{{ $loop->index }}">Delete</label>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p>No photos available.</p>
            @endif
        </div>
        <div class="row">
            <!-- Display Videos -->
            @if(!empty($travelMemory->videos))
                <h3>Videos</h3>
                @foreach ($travelMemory->videos as $video)
                    <div class="col-md-3">
                        <div class="card">
                            <video controls class="card-img-top">
                                <source src="{{ asset('storage/' . $video) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            <div class="card-body">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="media_to_delete[]" value="{{ $video }}" id="video-{{ $loop->index }}">
                                    <label class="form-check-label" for="video-{{ $loop->index }}">Delete</label>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p>No videos available.</p>
            @endif
        </div>
        <button type="submit" class="btn btn-danger mt-3">Delete Selected Media</button>
    </form>
    <a href="{{ route('travel-memories.index') }}" class="btn btn-secondary mt-3">Back to Memories</a>
</div>
@endsection
