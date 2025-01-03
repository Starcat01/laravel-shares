@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Edit Travel Memory</h1>
    <form action="{{ route('travel-memories.update', $travelMemory->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $travelMemory->title }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ $travelMemory->description }}</textarea>
        </div>
        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location" value="{{ $travelMemory->location }}">
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ $travelMemory->date }}">
        </div>
        <div class="mb-3">
            <label for="photos" class="form-label">Photos</label>
            <input type="file" class="form-control" id="photos" name="photos[]" multiple>
        </div>
        <div class="mb-3">
            <label for="videos" class="form-label">Videos</label>
            <input type="file" class="form-control" id="videos" name="videos[]" multiple>
        </div>
        <div class="mb-3">
            <label for="souvenirs" class="form-label">Souvenirs</label>
            <textarea class="form-control" id="souvenirs" name="souvenirs" rows="2">{{ $travelMemory->souvenirs }}</textarea>
        </div>
        <div class="mb-3">
            <label for="journal" class="form-label">Journal</label>
            <textarea class="form-control" id="journal" name="journal" rows="5">{{ $travelMemory->journal }}</textarea>
        </div>
        <div class="mb-3">
            <label for="map_url" class="form-label">Map URL</label>
            <input type="url" class="form-control" id="map_url" name="map_url" value="{{ $travelMemory->map_url }}">
        </div>
        <div class="mb-3">
            <label for="shared_recipes" class="form-label">Shared Recipes</label>
            <textarea class="form-control" id="shared_recipes" name="shared_recipes" rows="2">{{ $travelMemory->shared_recipes }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Travel Memory</button>
    </form>
</div>
@endsection
