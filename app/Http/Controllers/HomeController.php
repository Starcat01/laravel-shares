<?php

namespace App\Http\Controllers;

use App\Models\Portfolio; // Ensure you import the Portfolio model if needed
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
          // If you want to display portfolios on the home page
          $portfolios = Portfolio::all(); // This would retrieve all portfolio items
        
          return view('portfolio.index', compact('portfolios')); //   
      //  return view('portfolio.index');
    }
}
