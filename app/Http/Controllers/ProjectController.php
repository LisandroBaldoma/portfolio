<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Routing\Controller as BaseController;

class ProjectController extends BaseController
{
    public function show(Project $project)
    {
        $project->load('services');

        // Determine related projects: those that share at least one service
        $serviceIds = $project->services->pluck('id')->toArray();

        if (!empty($serviceIds)) {
            $relatedProjects = Project::where('is_active', true)
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->where('id', '!=', $project->id)
                ->whereHas('services', fn($q) => $q->whereIn('services.id', $serviceIds))
                ->with('services')
                ->orderBy('published_at', 'desc')
                ->take(4)
                ->get();
        } else {
            $relatedProjects = Project::where('is_active', true)
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->where('id', '!=', $project->id)
                ->with('services')
                ->orderBy('published_at', 'desc')
                ->take(4)
                ->get();
        }

        return view('project', compact('project', 'relatedProjects'));
    }
}
