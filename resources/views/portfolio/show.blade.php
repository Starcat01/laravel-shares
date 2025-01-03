@extends('layouts.app')

@section('title', $portfolio->title)

@section('content')
<div class="container mt-4">
    <!-- Back to Index Button -->
    <a href="{{ route('portfolio.index') }}" class="btn btn-secondary mb-4">
        <i class="fas fa-arrow-left"></i> Back to Portfolio List
    </a>

    <h2>{{ $portfolio->title }}</h2>

    <div class="row">
        <!-- Portfolio Content -->
        <div class="col-md-6">
            <p class="lead">{!! nl2br(e($portfolio->description)) !!}</p>
            <!-- Increased font size for laravel_snippet -->
            <pre class="bg-light p-3" style="font-size: 1.25rem;">{{ $portfolio->laravel_snippet }}</pre>

            <!-- Display Project Link -->
            @if($portfolio->link)
                <div class="mt-3">
                    <strong>Project Link:</strong>
                    <a href="{{ $portfolio->link }}" target="_blank" class="btn btn-outline-primary">
                        <i class="fas fa-link"></i> Visit Project
                    </a>
                </div>
            @else
                <p class="text-muted mt-3">No project link available.</p>
            @endif
        </div>

        <!-- Comments Section (Right Side) -->
        <div class="col-md-6">
            <h4>Comments</h4>

            <!-- Comment Submission Form -->
            <form action="{{ route('comments.store', $portfolio->id) }}" method="POST" class="mb-4">
                @csrf
                <div class="form-group">
                    <textarea name="content" class="form-control" rows="3" placeholder="Add your comment..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Submit Comment</button>
            </form>

            <!-- Display Comments -->
            <div class="comments-section">
                @forelse ($comments as $comment)
                    <div class="comment mb-3">
                        <div class="card p-3">
                            <p><strong>{{ $comment->user->name }}</strong></p>
                            <p>{{ $comment->content }}</p>

                            @if(auth()->check() && auth()->id() === $comment->user_id)
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this comment?');">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="lead text-muted text-center">No comments yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
