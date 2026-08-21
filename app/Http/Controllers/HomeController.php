<?php

namespace App\Http\Controllers;

use App\Services\ServiceService;
use Illuminate\Http\Request;
use App\Models\Project;

class HomeController extends Controller
{
    protected ServiceService $serviceService;

    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
    }

    public function index(Request $request)
    {
        $services = $this->serviceService->listForHome();

        $projects = Project::query()
            ->where('is_active', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->with('services')
            ->get();

        return view('home', compact('services', 'projects'));
    }
}
