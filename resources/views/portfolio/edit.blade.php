@extends('layouts.app')

@section('title', 'Edit Portfolio Snippet')

@section('content')
<div class="container">
    <h3 class="mt-4">Edit Portfolio Snippet</h3>

    <!-- Only show the form if the authenticated user matches the portfolio's user_id -->
    @if(auth()->check() && auth()->id() === $portfolio->user_id)
        @php
            $searchTerm = request()->input('search'); // Capture the search term from the request
            $highlightStyle = 'style="color:red;"'; // CSS style for highlighting
        @endphp

        <form action="{{ route('portfolio.update', $portfolio->id) }}" method="POST" class="mt-3">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $portfolio->title) }}" required>
                @error('title')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" required>{!! str_replace($searchTerm, "<span $highlightStyle>$searchTerm</span>", old('description', $portfolio->description)) !!}</textarea>
                @error('description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="laravel_snippet" class="form-label">Laravel Snippet</label>
                <textarea name="laravel_snippet" id="laravel_snippet" class="form-control" required>{{ old('laravel_snippet', $portfolio->laravel_snippet) }}</textarea>
                @error('laravel_snippet')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="link" class="form-label">Link</label>
                <input type="url" name="link" id="link" class="form-control" value="{{ old('link', $portfolio->link) }}">
                @error('link')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $portfolio->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Changes
            </button>
        </form>
    @else
        <p class="text-danger">You do not have permission to edit this portfolio snippet.</p>
    @endif
</div>
@endsection