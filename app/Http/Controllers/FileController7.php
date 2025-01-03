<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'file' => 'required|file|max:1024', // Max size of 1MB
            'portfolio_id' => 'required|exists:portfolios,id'
        ]);

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('uploads', 'public'); // Save to 'storage/app/public/uploads'

            // Save file record in the database
            $fileRecord = File::create([
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $filePath,
                'portfolio_id' => $request->portfolio_id, // Make sure to include the portfolio ID if required
                'user_id' => Auth::id(), // Store the ID of the user who uploaded the file
            ]);

            return redirect()->back()->with('success', 'File uploaded successfully.');
        }

        return redirect()->back()->with('error', 'File upload failed.');
    }

    public function destroy(File $file)
    {
        // Ensure the file belongs to the authenticated user
        if ($file->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // Delete the file from storage
        if (Storage::disk('public')->exists($file->file_path)) {
            Storage::disk('public')->delete($file->file_path);
        }

        // Delete the file record from the database
        $file->delete();

        return redirect()->back()->with('success', 'File deleted successfully.');
    }
}
