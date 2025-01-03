@extends('layouts.app')

@section('title', 'Add New Portfolio Snippet')

@section('content')
<div class="container">
    <h3 class="mt-4">Add New Portfolio Snippet</h3>
    <form action="{{ route('portfolio.store') }}" method="POST" class="mt-3">
        @csrf

        <!-- Title Field -->
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
            @error('title')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Description Field -->
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" required>{{ old('description') }}</textarea>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Laravel Snippet Field -->
        <div class="mb-3">
            <label for="laravel_snippet" class="form-label">Laravel Snippet</label>
            <textarea name="laravel_snippet" id="laravel_snippet" class="form-control" required>{{ old('laravel_snippet') }}</textarea>
            @error('laravel_snippet')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Link Field -->
        <div class="mb-3">
            <label for="link" class="form-label">Link</label>
            <input type="url" name="link" id="link" class="form-control" value="{{ old('link') }}">
            @error('link')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Category Selection -->
        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">Select a category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>  
        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-plus"></i> Save
        </button>
    </form>    

         
</div>
@endsection