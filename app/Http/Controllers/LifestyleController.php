<?php
namespace App\Http\Controllers;
use App\Models\Lifestyle; // Use the correct model name
use App\Models\LifestyleProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LifestyleController extends Controller
{
     // Define the show method
     public function show($id)
     {
         // Fetch the lifestyle entry by its ID
         $lifestyle = LifestyleProfile::findOrFail($id);
 
         // Return a view or JSON response
         return view('lifestyles.show', compact('lifestyle'));
         // Or if you're using API return
         // return response()->json($lifestyle);
     }
 
 
    /**
     * Display a listing of the lifestyle profiles.
     */
    public function index()
    {
        $lifestyles = LifestyleProfile::where('user_id', Auth::id())->get();
        return view('lifestyles.index', compact('lifestyles'));
    }
    /**
     * Show the form for creating a new lifestyle profile.
     */
    public function create()
    {
        return view('lifestyles.create');
    }
    /**
     * Store a newly created lifestyle profile in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'daily_routine' => 'nullable|array',
            'occupation' => 'nullable|string',
            'work_environment' => 'nullable|string',
            'health_wellness' => 'nullable|array',
            'social_life' => 'nullable|array',
            'religion' => 'nullable|string',
            'cultural_practices' => 'nullable|array',
            'residence_type' => 'nullable|string',
            'financial_habits' => 'nullable|array',
            'travel_exploration' => 'nullable|array',
            'fashion_style' => 'nullable|array',
            'entertainment_choices' => 'nullable|array',
            'technology_gadgets' => 'nullable|array',
            'eco_practices' => 'nullable|array',
            'goals_aspirations' => 'nullable|array',
            'unique_quirks' => 'nullable|array',
        ]);
        LifestyleProfile::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'daily_routine' => $request->daily_routine,
            'occupation' => $request->occupation,
            'work_environment' => $request->work_environment,
            'health_wellness' => $request->health_wellness,
            'social_life' => $request->social_life,
            'religion' => $request->religion,
            'cultural_practices' => $request->cultural_practices,
            'residence_type' => $request->residence_type,
            'financial_habits' => $request->financial_habits,
            'travel_exploration' => $request->travel_exploration,
            'fashion_style' => $request->fashion_style,
            'entertainment_choices' => $request->entertainment_choices,
            'technology_gadgets' => $request->technology_gadgets,
            'eco_practices' => $request->eco_practices,
            'goals_aspirations' => $request->goals_aspirations,
            'unique_quirks' => $request->unique_quirks,
        ]);
        return redirect()->route('lifestyles.index')->with('success', 'Lifestyle profile created successfully.');
    }
    /**
     * Show the form for editing the specified lifestyle profile.
     */
    public function edit(LifestyleProfile $lifestyle)
    {
        $this->authorizeOwnership($lifestyle);
        return view('lifestyles.edit', compact('lifestyle'));
    }
    /**
     * Update the specified lifestyle profile in storage.
     */
    public function update(Request $request, LifestyleProfile $lifestyle)
    {
        $this->authorizeOwnership($lifestyle);
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'daily_routine' => 'nullable|array',
            'occupation' => 'nullable|string',
            'work_environment' => 'nullable|string',
            'health_wellness' => 'nullable|array',
            'social_life' => 'nullable|array',
            'religion' => 'nullable|string',
            'cultural_practices' => 'nullable|array',
            'residence_type' => 'nullable|string',
            'financial_habits' => 'nullable|array',
            'travel_exploration' => 'nullable|array',
            'fashion_style' => 'nullable|array',
            'entertainment_choices' => 'nullable|array',
            'technology_gadgets' => 'nullable|array',
            'eco_practices' => 'nullable|array',
            'goals_aspirations' => 'nullable|array',
            'unique_quirks' => 'nullable|array',
        ]);
        $lifestyle->update($request->all());
        return redirect()->route('lifestyles.index')->with('success', 'Lifestyle profile updated successfully.');
    }
    /**
     * Remove the specified lifestyle profile from storage.
     */
    public function destroy(LifestyleProfile $lifestyle)
    {
        $this->authorizeOwnership($lifestyle);
        $lifestyle->delete();
        return redirect()->route('lifestyles.index')->with('success', 'Lifestyle profile deleted successfully.');
    }
    /**
     * Ensure the authenticated user owns the lifestyle profile.
     */
    private function authorizeOwnership(LifestyleProfile $lifestyle)
    {
        if ($lifestyle->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
