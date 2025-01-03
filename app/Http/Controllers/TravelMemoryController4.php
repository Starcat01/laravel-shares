<?php
namespace App\Http\Controllers;
use App\Models\TravelMemory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class TravelMemoryController extends Controller
{
    /**
     * Display a listing of the travel memories.
     */
    public function index()
    {
        // Get all travel memories for the authenticated user
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
            'souvenirs' => 'nullable|string',
            'journal' => 'nullable|string',
            'ticket_details' => 'nullable|string',
            'map_url' => 'nullable|url',
            'shared_recipes' => 'nullable|string',
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
            'souvenirs' => $request->souvenirs,
            'journal' => $request->journal,
            'ticket_details' => $request->ticket_details,
            'map_url' => $request->map_url,
            'shared_recipes' => $request->shared_recipes,
        ]);
        return redirect()->route('travel-memories.index')->with('success', 'Travel memory created successfully.');
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
            'souvenirs' => 'nullable|string',
            'journal' => 'nullable|string',
            'ticket_details' => 'nullable|string',
            'map_url' => 'nullable|url',
            'shared_recipes' => 'nullable|string',
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
            'souvenirs' => $request->souvenirs,
            'journal' => $request->journal,
            'ticket_details' => $request->ticket_details,
            'map_url' => $request->map_url,
            'shared_recipes' => $request->shared_recipes,
        ]);
        return redirect()->route('travel-memories.index')->with('success', 'Travel memory updated successfully.');
    }
    /**
     * Remove the specified travel memory from storage.
     */
    public function destroy(TravelMemory $travelMemory)
    {
        if ($travelMemory->user_id !== Auth::id()) {
            return redirect()->route('travel-memories.index')->with('error', 'Unauthorized action.');
        }
        $travelMemory->delete();
        return redirect()->route('travel-memories.index')->with('success', 'Travel memory deleted successfully.');
    }
}
