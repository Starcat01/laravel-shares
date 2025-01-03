@extends('layouts.app')

@section('title', $portfolio->title)

@section('content')
<div class="container mt-4">
    <h2>{{ $portfolio->title }}</h2>
    
    <div class="row">
        <!-- Content -->
        <div class="col-6">
            <p class="lead">{!! nl2br(e($portfolio->description)) !!}</p>
            <pre class="bg-light p-3">{{ $portfolio->laravel_snippet }}</pre>

            @if($portfolio->link)
                <a href="{{ $portfolio->link }}" target="_blank" class="btn btn-outline-primary mt-3">
                    <i class="fas fa-link"></i> Project Link
                </a>
            @endif

            <!-- Display the linked file -->
            @if($portfolio->file_link)
                <div class="mt-3">
                    <p><strong>Linked File:</strong></p>
                    <p>Name: {{ basename($portfolio->file_link) }}</p>
                    <p>Path: <a href="{{ asset('storage/' . $portfolio->file_link) }}" target="_blank">{{ asset('storage/' . $portfolio->file_link) }}</a></p>
                </div>
            @else
                <p class="text-muted mt-3">No linked file.</p>
            @endif
          
            <!-- File upload form -->
            <form action="{{ route('files.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="file">Upload File:</label>
                    <input type="file" name="file" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>

            <div class="mt-3">
                @if(auth()->check() && auth()->id() === $portfolio->user_id)
                    <a href="{{ route('portfolio.edit', $portfolio->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('portfolio.destroy', $portfolio->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?');">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </form>
                @endif
                <a href="{{ route('portfolio.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Portfolio
                </a>
            </div>
        </div>  

        <!-- Comment Section -->
        <div class="col-6">
            <h4>Comments</h4>

            <!-- Comments Submission Form -->
            <form action="{{ route('comments.store', $portfolio->id) }}" method="POST" class="mb-4">
                @csrf
                <div class="form-group">
                    <input name="content" class="form-control" rows="3" placeholder="Add your comment..." required>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Submit Comment</button>
            </form>

            <!-- Display Comments -->
            <div class="comments-section">
                @forelse ($comments as $comment)
                    <div class="comment mb-3">
                        <div class="card p-3">
                            <div class="d-flex align-items-center mb-2">
                                <strong>{{ $comment->user->name }}</strong>
                            </div>
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
