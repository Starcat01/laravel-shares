<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    // Method to show the user profile
    public function show()
    {
        // Get the currently logged-in user
        $user = Auth::user(); 
        
        return view('profile.show', compact('user'));
    }

    // Method to handle the update request
    public function update(Request $request)
    {
        // Get the currently logged-in user
        $user = Auth::user();

        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'bio' => 'nullable|string|max:500',
        ]);
        
        // Call save method
        $this->save($request, $user);

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }

    // Method to save user profile information
    private function save(Request $request, User $user)
    {
        // Update user information
        $user->name = $request->name;
        $user->email = $request->email;
        $user->bio = $request->bio;

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path; // Save the path in the user model
        }

        // Save the changes to the authenticated user
        $user->save();
    }

    
// Method to copy avatars from the storage to public directory
public function copyAvatars()
{
    $sourcePath = 'public/avatars';  // Relative path in storage/app
    $destinationPath = 'public/avatars'; // This refers to where you want to store them in the public directory

    // Check if the source directory exists
    if (Storage::disk('public')->exists($sourcePath)) {
        // Create destination directory if it doesn't exist
        if (!Storage::disk('public')->exists($destinationPath)) {
            Storage::disk('public')->makeDirectory($destinationPath);
        }

        // Get the list of avatar files in the source directory
        $files = Storage::disk('public')->files($sourcePath);

        // Copy each file to the destination
        foreach ($files as $file) {
            $fileName = basename($file);
            $destinationFilePath = $destinationPath . '/' . $fileName;

            // Copy the file, taking care not to overwrite if it already exists
            if (!Storage::disk('public')->exists($destinationFilePath)) {
                Storage::disk('public')->copy($file, $destinationFilePath);
            }
        }

        return response()->json(['success' => 'Avatars copied successfully.']);
    } else {
        return response()->json(['error' => 'Source directory does not exist.'], 404);
    }
}
}