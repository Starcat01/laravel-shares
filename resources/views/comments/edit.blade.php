@extends('layouts.app')

@section('title', 'Edit Comment')

@section('content')
<div class="container">
    <h3 class="mt-4">Edit Comment</h3>

    <form action="{{ route('comments.update', $comment->id) }}" method="POST">
        @csrf
        @method('PATCH') <!-- Use PATCH for updating -->

        <div class="mb-3">
            <label for="content" class="form-label">Comment</label>
            <textarea name="content" id="content" class="form-control" required>{{ old('content', $comment->content) }}</textarea>
            @error('content')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Save Changes
        </button>
        
        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Cancel
        </a>
    </form>
</div>
@endsection