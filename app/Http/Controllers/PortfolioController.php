<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortfolioController extends Controller
{
    private $portfolio;

    public function __construct(Portfolio $portfolio)
    {
        $this->portfolio = $portfolio;
    }

    // Display all portfolio items with their categories, optionally filtered by search
    public function index(Request $request)
    {
        $query = Portfolio::with('category');

        // If there is a search term, filter portfolios based on title and description
        if ($request->has('search') && !empty($request->input('search'))) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', '%' . $search . '%')
                  ->orWhere('title', 'like', '%' . $search . '%');
            });
        }

        $portfolios = $query->get();

        return view('portfolio.index', compact('portfolios'));
    }

    // Show form for creating a new portfolio item
    public function create()
    {
        $categories = Category::all();
        return view('portfolio.create', compact('categories'));
    }

    // Store a new portfolio item
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'laravel_snippet' => 'required',
            'link' => 'nullable|url',
            'category_id' => 'required|exists:categories,id',
        ]);

        Portfolio::create($request->merge(['user_id' => Auth::id()])->all());

        return redirect()->route('portfolio.index')
            ->with('success', 'Portfolio item created successfully.');
    }

    // Display a specific portfolio item with comments
    public function show(Portfolio $portfolio)
    {
        $comments = $portfolio->comments()->with('user')->get();
        return view('portfolio.show', compact('portfolio', 'comments'));
    }

    // Show form for editing a portfolio item
    public function edit(Portfolio $portfolio)
    {
        $categories = Category::all();
        return view('portfolio.edit', compact('portfolio', 'categories'));
    }

    // Update an existing portfolio item
    public function update(Request $request, Portfolio $portfolio)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'laravel_snippet' => 'required',
            'link' => 'nullable|url',
            'category_id' => 'required|exists:categories,id',
        ]);

        $portfolio->update($request->all());

        return redirect()->route('portfolio.index')
            ->with('success', 'Portfolio item updated successfully.');
    }

    // Delete a portfolio item
    public function destroy(Portfolio $portfolio)
    {
        $portfolio->delete();

        return redirect()->route('portfolio.index')
            ->with('success', 'Portfolio item deleted successfully.');
    }

    // Search portfolios function can be removed since search is integrated in index
    // If you need a separate search view, this can be kept for that purpose
    public function search(Request $request)
    {
        $search = $request->input('search');
        $portfolios = $this->portfolio->where(function ($query) use ($search) {
            $query->where('description', 'like', '%' . $search . '%')
                  ->orWhere('title', 'like', '%' . $search . '%');
        })->get();

        return view('portfolio.search', compact('portfolios', 'search'));
    }

    // Store comment 
    public function storeComment(Request $request, Portfolio $portfolio)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $portfolio->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->content,  
        ]);

        return redirect()->route('portfolio.show', $portfolio->id)
            ->with('success', 'Comment added successfully.');
    }

    // Travel index method 
    public function travelIndex()
    {
        // Your logic here
        return view('travel.index');
    }
    // Lifestyle index method
    public function lifestyleIndex()
    {
        // Your logic to handle the lifestyle index view
        return view('lifestyle.index'); 
    }
}