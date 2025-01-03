<?php

namespace App\Http\Controllers;

use App\Models\TravelMemory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TravelMemoryController extends Controller
{
    /**
     * Display a listing of the travel memories.
     */
    public function index()
    {
        $travelMemories = TravelMemory::where('user_id', Auth::id())->get();
        return view('travel-memories.index', compact('travelMemories'));
    }

    /**
     * Show the form for creating a new travel memory.
     */
    public function create()
    {
        return view('travel-memories.create');
    }

    /**
     * Store a newly created travel memory in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string',
            'date' => 'nullable|date',
            'photos.*' => 'nullable|mimes:jpg,jpeg,png|max:4096',
            'videos.*' => 'nullable|mimes:mp4,avi,mov|max:51200',
        ]);

        $photoPaths = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $photoPaths[] = $photo->store('photos', 'public');
            }
        }

        $videoPaths = [];
        if ($request->hasFile('videos')) {
            foreach ($request->file('videos') as $video) {
                $videoPaths[] = $video->store('videos', 'public');
            }
        }

        TravelMemory::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'date' => $request->date,
            'photos' => $photoPaths,
            'videos' => $videoPaths,
        ]);

        return redirect()->route('travel-memories.index')->with('success', 'Travel memory created successfully.');
    }

    /**
     * Display a specific travel memory.
     */
    public function show(TravelMemory $travelMemory)
    {
        if ($travelMemory->user_id !== Auth::id()) {
            return redirect()->route('travel-memories.index')->with('error', 'Unauthorized action.');
        }
        return view('travel-memories.show', compact('travelMemory'));
    }

    /**
     * Show the form for editing the specified travel memory.
     */
    public function edit(TravelMemory $travelMemory)
    {
        if ($travelMemory->user_id !== Auth::id()) {
            return redirect()->route('travel-memories.index')->with('error', 'Unauthorized action.');
        }
        return view('travel-memories.edit', compact('travelMemory'));
    }

    /**
     * Update the specified travel memory in storage.
     */
    public function update(Request $request, TravelMemory $travelMemory)
    {
        if ($travelMemory->user_id !== Auth::id()) {
            return redirect()->route('travel-memories.index')->with('error', 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string',
            'date' => 'nullable|date',
            'photos.*' => 'nullable|mimes:jpg,jpeg,png|max:2048',
            'videos.*' => 'nullable|mimes:mp4,avi,mov|max:51200',
        ]);

        $photoPaths = $travelMemory->photos ?? [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $photoPaths[] = $photo->store('photos', 'public');
            }
        }

        $videoPaths = $travelMemory->videos ?? [];
        if ($request->hasFile('videos')) {
            foreach ($request->file('videos') as $video) {
                $videoPaths[] = $video->store('videos', 'public');
            }
        }

        $travelMemory->update([
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'date' => $request->date,
            'photos' => $photoPaths,
            'videos' => $videoPaths,
        ]);

        return redirect()->route('travel-memories.index')->with('success', 'Travel memory updated successfully.');
    }

    /**
     * Display photos and videos for deletion.
     */
    public function showMediaForDeletion(TravelMemory $travelMemory)
    {
        if ($travelMemory->user_id !== Auth::id()) {
            return redirect()->route('travel-memories.index')->with('error', 'Unauthorized action.');
        }

        return view('travel-memories.media-delete', compact('travelMemory'));
    }

    /**
     * Handle deletion of selected photos and videos.
     */
    public function deleteMedia(Request $request, TravelMemory $travelMemory)
    {
        if ($travelMemory->user_id !== Auth::id()) {
            return redirect()->route('travel-memories.index')->with('error', 'Unauthorized action.');
        }

        $request->validate([
            'media_to_delete' => 'required|array',
            'media_to_delete.*' => 'string',
        ]);

        $updatedPhotos = collect($travelMemory->photos)->reject(function ($media) use ($request) {
            if (in_array($media, $request->media_to_delete)) {
                Storage::disk('public')->delete($media);
                return true;
            }
            return false;
        })->values()->all();

        $updatedVideos = collect($travelMemory->videos)->reject(function ($media) use ($request) {
            if (in_array($media, $request->media_to_delete)) {
                Storage::disk('public')->delete($media);
                return true;
            }
            return false;
        })->values()->all();

        $travelMemory->update([
            'photos' => $updatedPhotos,
            'videos' => $updatedVideos,
        ]);

        return redirect()->route('travel-memories.showMediaForDeletion', $travelMemory)
            ->with('success', 'Selected media deleted successfully.');
    }

    /**
     * Remove the specified travel memory from storage.
     */
    public function destroy(TravelMemory $travelMemory)
    {
        if ($travelMemory->user_id !== Auth::id()) {
            return redirect()->route('travel-memories.index')->with('error', 'Unauthorized action.');
        }

        // Delete associated media files
        foreach ($travelMemory->photos as $photo) {
            Storage::disk('public')->delete($photo);
        }

        foreach ($travelMemory->videos as $video) {
            Storage::disk('public')->delete($video);
        }

        $travelMemory->delete();

        return redirect()->route('travel-memories.index')->with('success', 'Travel memory deleted successfully.');
    }
    
  
   
}
