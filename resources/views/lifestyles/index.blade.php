@extends('layouts.app')
@section('title', 'Lifestyle Profiles')
@section('content')
<div class="container">
    <h4 class="mt-4">Lifestyle Profiles</h4>
    
    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <!-- Create New Profile Button -->
    <a href="{{ route('lifestyles.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Create New Profile
    </a>
    
    <!-- List of Lifestyle Profiles -->
    @if($lifestyles->count() > 0)
        <ul class="list-group">
            @foreach($lifestyles as $lifestyle)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <!-- Profile Name -->
                        <h5 class="mb-1">
                            <a href="{{ route('lifestyles.show', $lifestyle->id) }}" class="text-decoration-none">
                                {{ $lifestyle->name }}
                            </a>
                        </h5>
                        <!-- Profile Description -->
                        <p class="mb-1 text-muted">{{ $lifestyle->description }}</p>
                        <!-- Last Updated Timestamp -->
                        <small>Last updated: {{ $lifestyle->updated_at->diffForHumans() }}</small>
                    </div>
                    <div>
                        <!-- Edit Button -->
                        <a href="{{ route('lifestyles.edit', $lifestyle->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        
                        <!-- Delete Button -->
                        <form action="{{ route('lifestyles.destroy', $lifestyle->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this profile?');">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-muted">No lifestyle profiles found. Create a new one to get started.</p>
    @endif
</div>
@endsection
