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
     * Store a newly created travel memory in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string',
            'date' => 'nullable|date',
            'photos' => 'nullable|array',
            'videos' => 'nullable|array',
            'souvenirs' => 'nullable|string',
            'journal' => 'nullable|string',
            'ticket_details' => 'nullable|array',
            'map_url' => 'nullable|url',
            'shared_recipes' => 'nullable|string',
        ]);
        // Create the travel memory
        TravelMemory::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'date' => $request->date,
            'photos' => $request->photos,
            'videos' => $request->videos,
            'souvenirs' => $request->souvenirs,
            'journal' => $request->journal,
            'ticket_details' => $request->ticket_details,
            'map_url' => $request->map_url,
            'shared_recipes' => $request->shared_recipes,
        ]);
        return redirect()->route('travel-memories.index')->with('success', 'Travel memory saved successfully.');
    }
    /**
     * Show the form for editing the specified travel memory.
     */
    public function edit(TravelMemory $travelMemory)
    {
        // Ensure the travel memory belongs to the authenticated user
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
        // Ensure the travel memory belongs to the authenticated user
        if ($travelMemory->user_id !== Auth::id()) {
            return redirect()->route('travel-memories.index')->with('error', 'Unauthorized action.');
        }
        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string',
            'date' => 'nullable|date',
            'photos' => 'nullable|array',
            'videos' => 'nullable|array',
            'souvenirs' => 'nullable|string',
            'journal' => 'nullable|string',
            'ticket_details' => 'nullable|array',
            'map_url' => 'nullable|url',
            'shared_recipes' => 'nullable|string',
        ]);
        // Update the travel memory
        $travelMemory->update([
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'date' => $request->date,
            'photos' => $request->photos,
            'videos' => $request->videos,
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
        // Ensure the travel memory belongs to the authenticated user
        if ($travelMemory->user_id !== Auth::id()) {
            return redirect()->route('travel-memories.index')->with('error', 'Unauthorized action.');
        }
        $travelMemory->delete();
        return redirect()->route('travel-memories.index')->with('success', 'Travel memory deleted successfully.');
    }
}
