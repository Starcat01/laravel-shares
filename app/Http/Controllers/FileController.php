<?php
namespace App\Http\Controllers;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Store a newly uploaded file in the database and storage
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'file' => 'required|file|max:1024', // Max size of 1MB
            'portfolio_id' => 'nullable|exists:portfolios,id', // Optional portfolio_id validation key points
        ]);
        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('uploads', 'public'); // Save to 'storage/app/public/uploads'
            
            
            // Save file record in the database
            $fileRecord = File::create([
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $filePath,
                'portfolio_id' => $request->portfolio_id,
                'user_id' => Auth::id(),
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
    public function update(Request $request, File $file)
    {
        // Validate the request
        $request->validate([
            'file' => 'required|file|max:1024', // Max size of 1MB
        ]);
        // Ensure the file belongs to the authenticated user
        if ($file->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }
        // Delete the old file from storage
        if (Storage::disk('public')->exists($file->file_path)) {
            Storage::disk('public')->delete($file->file_path);
        }
        // Handle the new file upload
        if ($request->hasFile('file')) {
            $newFile = $request->file('file');
            $newFilePath = $newFile->store('uploads', 'public');
            // Update the file record in the database
            $file->update([
                'file_name' => $newFile->getClientOriginalName(),
                'file_path' => $newFilePath,
            ]);
            return redirect()->back()->with('success', 'File updated successfully.');
        }
        return redirect()->back()->with('error', 'File update failed.');
    }
}
