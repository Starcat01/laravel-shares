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
            <!-- Display the uploaded file linked to the portfolio -->
            @if($portfolio->file_link && auth()->id() === $portfolio->user_id)
                <div class="mt-3">
                    <p><strong>Your Uploaded File:</strong></p>
                    <p>Name: {{ basename($portfolio->file_link) }}</p>
                    <p>
                        Path: 
                        <a href="{{ asset('storage/' . $portfolio->file_link) }}" target="_blank">
                            {{ asset('storage/' . $portfolio->file_link) }}
                        </a>
                    </p>
                </div>
            @else
                <p class="text-muted mt-3">No file uploaded by you.</p>
            @endif
            <!-- Display all files uploaded by the current user -->
            <div class="mt-3">
                <h4>Your Uploaded Files</h4>
                @php
                    $files = \App\Models\File::where('user_id', auth()->id())->get();
                @endphp
                @if($files->count() > 0)
                    <ul>
                        @foreach($files as $file)
                            <li>
                                <strong>Name:</strong> {{ $file->file_name }}<br>
                                <strong>Path:</strong> 
                                <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank">
                                    {{ asset('storage/' . $file->file_path) }}
                                </a>
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
                <input type="hidden" name="portfolio_id" value="{{ $portfolio->id }}">
                <button type="submit" class="btn btn-primary mt-2">Upload</button>
            </form>
        </div>
    </div>
</div>
@endsection
