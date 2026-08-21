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
        $selectedService = $request->query('service');

        $services = $this->serviceService->listForHome();

        $projects = Project::query()
            ->where('is_active', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->when($selectedService, fn($q) => $q->whereHas('services', fn($q2) => $q2->where('services.id', $selectedService)))
            ->orderBy('published_at', 'desc')
            ->with('services')
            ->get();

        return view('home', compact('services', 'projects', 'selectedService'));
    }
}
