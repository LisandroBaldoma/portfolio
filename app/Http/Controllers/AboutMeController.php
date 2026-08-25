<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\View\View;

class AboutMeController extends Controller
{
    public function index(): View
    {
        $projects = Project::query()
            ->where('is_active', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->with('services')
            ->orderByDesc('published_at')
            ->get();

        return view('aboutme', compact('projects'));
    }
}
