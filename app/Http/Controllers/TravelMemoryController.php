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
     * Show the media add form for a specific travel memory.
     */
    public function addMedia(TravelMemory $travelMemory)
    {
        if ($travelMemory->user_id !== Auth::id()) {
            return redirect()->route('travel-memories.index')->with('error', 'Unauthorized action.');
        }
        return view('travel-memories.media-add', compact('travelMemory'));
    }

    /**
     * Store new media for a specific travel memory.
     */
    public function storeMedia(Request $request, TravelMemory $travelMemory)
    {
        if ($travelMemory->user_id !== Auth::id()) {
            return redirect()->route('travel-memories.index')->with('error', 'Unauthorized action.');
        }

        $request->validate([
            'photos.*' => 'nullable|mimes:jpg,jpeg,png|max:4096',
            'videos.*' => 'nullable|mimes:mp4,avi,mov|max:51200',
        ]);

        // Handle new photos
        $newPhotos = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $newPhotos[] = $photo->store('photos', 'public');
            }
        }

        // Handle new videos
        $newVideos = [];
        if ($request->hasFile('videos')) {
            foreach ($request->file('videos') as $video) {
                $newVideos[] = $video->store('videos', 'public');
            }
        }

        // Update the travel memory
        $travelMemory->update([
            'photos' => array_merge($travelMemory->photos ?? [], $newPhotos),
            'videos' => array_merge($travelMemory->videos ?? [], $newVideos),
        ]);

        return redirect()->route('travel-memories.show', $travelMemory->id)->with('success', 'Media added successfully.');
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
    * Delete specified media from the travel memory.
    */
   public function deleteMedia(Request $request, TravelMemory $travelMemory)
   {
       // Ensure the user is authorized to delete media from this travel memory
       if ($travelMemory->user_id !== Auth::id()) {
           return redirect()->route('travel-memories.index')->with('error', 'Unauthorized action.');
       }

       // Validate the request input
       $request->validate([
           'media_to_delete' => 'required|array',
           'media_to_delete.*' => 'string', // Ensuring the input is treated as string paths
       ]);

       // Delete the specified media files
       foreach ($request->input('media_to_delete') as $mediaPath) {
           // Check if the media path exists in the travel memory's photos or videos
           if (in_array($mediaPath, $travelMemory->photos)) {
               Storage::disk('public')->delete($mediaPath);
               // Remove the path from the database array if using a database to store paths
               $travelMemory->photos = array_diff($travelMemory->photos, [$mediaPath]);
           }

           if (in_array($mediaPath, $travelMemory->videos)) {
               Storage::disk('public')->delete($mediaPath);
               // Remove the path from the database array if using a database to store paths
               $travelMemory->videos = array_diff($travelMemory->videos, [$mediaPath]);
           }
       }

       // Update the travel memory to reflect changes in the database
       $travelMemory->save();

       // Redirect back with a success message
       return redirect()->route('travel-memories.index', $travelMemory->id)->with('success', 'Media deleted successfully.');
   }

    /**
     * Display a specific travel memory.
     */
    public function show(TravelMemory $travelMemory)
    {
        // Ensure the travel memory belongs to the authenticated user
        if ($travelMemory->user_id !== Auth::id()) {
            return redirect()->route('travel-memories.index')->with('error', 'Unauthorized action.');
        }
        return view('travel-memories.show', compact('travelMemory'));
    }

}
