<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Middleware should be handled in routes
    }

    /**
     * Show the application dashboard.
     */
    public function index(): Renderable
    {
        return view('home');
    }
}
