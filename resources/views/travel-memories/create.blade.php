@extends('layouts.app')
@section('content')
<div class="container">
    <h4>Create a New Travel Memory</h4>
    <form action="{{ route('travel-memories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Title -->
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <!-- Description -->
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        <!-- Location -->
        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location">
        </div>
        <!-- Date -->
        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date">
        </div>
        <!-- Photos -->
        <div class="mb-3">
            <label for="photos" class="form-label">Photos</label>
            <input type="file" class="form-control" id="photos" name="photos[]" multiple>
            <small class="text-muted">You can upload multiple photos.</small>
        </div>
        <!-- Videos -->
        <div class="mb-3">
            <label for="videos" class="form-label">Videos</label>
            <input type="file" class="form-control" id="videos" name="videos[]" multiple>
            <small class="text-muted">You can upload multiple videos.</small>
        </div>
        <!-- Souvenirs -->
        <div class="mb-3">
            <label for="souvenirs" class="form-label">Souvenirs</label>
            <textarea class="form-control" id="souvenirs" name="souvenirs" rows="2"></textarea>
        </div>
        <!-- Journal -->
        <div class="mb-3">
            <label for="journal" class="form-label">Travel Journal</label>
            <textarea class="form-control" id="journal" name="journal" rows="5"></textarea>
        </div>
        <!-- Ticket Details -->
        <div class="mb-3">
            <label for="ticket_details" class="form-label">Ticket Details</label>
            <textarea class="form-control" id="ticket_details" name="ticket_details" rows="3"></textarea>
        </div>
        <!-- Map URL -->
        <div class="mb-3">
            <label for="map_url" class="form-label">Map URL</label>
            <input type="url" class="form-control" id="map_url" name="map_url">
        </div>
        <!-- Shared Recipes -->
        <div class="mb-3">
            <label for="shared_recipes" class="form-label">Shared Recipes</label>
            <textarea class="form-control" id="shared_recipes" name="shared_recipes" rows="3"></textarea>
        </div>
        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Save Travel Memory</button>
    </form>
</div>
@endsection