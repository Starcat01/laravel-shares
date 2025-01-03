<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // Store a new comment
    public function store(Request $request, $portfolioId)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        Comment::create([
            'portfolio_id' => $portfolioId,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->route('portfolio.show', $portfolioId)->with('success', 'Comment added successfully.');
    }

    // Edit an existing comment
    public function edit($id)
    {
        $comment = Comment::findOrFail($id);
        return view('comments.edit', compact('comment'));
    }

    // Update an existing comment
    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $comment = Comment::findOrFail($id);

        if ($comment->user_id !== Auth::id()) {
            return redirect()->route('portfolio.show', $comment->portfolio_id)->with('error', 'Unauthorized action.');
        }

        $comment->update(['content' => $request->content]);

        return redirect()->route('portfolio.show', $comment->portfolio_id)->with('success', 'Comment updated successfully.');
    }

    // Delete a comment
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id !== Auth::id()) {
            return redirect()->route('portfolio.show', $comment->portfolio_id)->with('error', 'Unauthorized action.');
        }

        $comment->delete();

        return redirect()->route('portfolio.show', $comment->portfolio_id)->with('success', 'Comment deleted successfully.');
    }
}