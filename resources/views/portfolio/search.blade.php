@extends('layouts.app')

@section('title', 'Portfolio Search Results')

@section('content')
    <div class="container">
        <h3 class="mt-4">Search results for "<span class="fw-bold">{{ $search }}</span>"</h3>

        <!-- Back to Portfolio Button -->
        <a href="{{ route('portfolio.index') }}" class="btn btn-secondary mb-3">
            <i class="fas fa-arrow-left"></i> Back to Portfolio
        </a>

        <ul class="list-group">
            @forelse ($portfolios as $portfolio)
                <li class="list-group-item">
                    <a href="{{ route('portfolio.show', $portfolio->id) }}" class="h5">{{ $portfolio->title }}</a>
                    <p>{{ Str::limit($portfolio->description, 100) }}</p>
                </li>
            @empty
                <p class="lead text-muted text-center">No portfolios found.</p>
            @endforelse
        </ul>
    </div>
@endsection