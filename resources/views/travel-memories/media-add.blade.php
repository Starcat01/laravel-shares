@extends('layouts.app')
@section('content')
<div class="container">
    <h4>Add Media to "{{ $travelMemory->title }}"</h4>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <form action="{{ route('travel-memories.storeMedia', $travelMemory->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="photos" class="form-label">Add Photos</label>
            <input type="file" name="photos[]" id="photos" class="form-control" multiple>
        </div>
        <div class="mb-3">
            <label for="videos" class="form-label">Add Videos</label>
            <input type="file" name="videos[]" id="videos" class="form-control" multiple>
        </div>
        <button type="submit" class="btn btn-primary">Add Media</button>
        <a href="{{ route('travel-memories.index') }}" class="btn btn-secondary">Back to Memories</a>
    </form>
</div>
@endsection
