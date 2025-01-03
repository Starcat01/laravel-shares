@extends('layouts.app')

@section('title', 'Portfolio Snippets')

@section('content')
<div class="container">
    <h3 class="mt-4">Portfolio Snippet</h3>

    <!-- Search Form -->
    <form action="{{ route('portfolio.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="search" name="search" class="form-control" placeholder="Search in titles and descriptions..." value="{{ request()->input('search') }}">
            <button type="submit" class="btn btn-outline-secondary">Search</button>
        </div>
    </form>

    <a href="{{ route('portfolio.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Add New Portfolio Snippet
    </a>

    <ul class="list-group">
        @php
            $searchTerm = request()->input('search');
            $highlightStyle = 'style="color:red;"';
        @endphp

        @foreach($portfolios as $portfolio)
            <li class="list-group-item d-flex align-items-center">
                <div class="flex-grow-1">
                    <a href="{{ route('portfolio.show', $portfolio->id) }}" class="h5">
                        {!! str_replace($searchTerm, "<span $highlightStyle>$searchTerm</span>", $portfolio->title) !!}
                    </a>
                    <p>
                        {!! str_replace($searchTerm, "<span $highlightStyle>$searchTerm</span>", Str::limit($portfolio->description, 100)) !!}
                    </p>
                    <p class="text-muted">Posted by: {{ $portfolio->user->name }}</p>
                </div>

                @if(auth()->check() && auth()->id() === $portfolio->user_id)
                    <a href="{{ route('portfolio.edit', $portfolio->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('portfolio.destroy', $portfolio->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?');">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </form>
                @endif
            </li>
        @endforeach
    </ul>

    <!-- Display all files uploaded by the current user -->
    <div class="mt-3">
        <h4>Your Uploaded Files</h4>
        @php
            $files = \App\Models\File::where('user_id', auth()->id())->get();
        @endphp
        @if($files->count() > 0)
            <ul>
                @foreach($files as $file)
                    <li class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>File:</strong> {{ $file->file_name }} 
                            <a href="{{ url('storage/' . $file->file_path) }}" target="_blank" class="btn btn-link">
                                <i class="fas fa-download"></i> <!-- Download icon -->
                            </a>
                        </div>
                        <!-- Delete File Button -->
                        <form action="{{ route('files.destroy', $file->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this file?');">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-muted">No files uploaded yet.</p>
        @endif
    </div>

    <!-- File upload form -->
    <form action="{{ route('files.store') }}" method="POST" enctype="multipart/form-data" class="mt-3">
        @csrf
        <div class="form-group">
            <label for="file">Upload File:</label>
            <input type="file" name="file" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Upload</button>
    </form>
</div>
@endsection