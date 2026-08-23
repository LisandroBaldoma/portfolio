<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;

class ProjectController extends BaseController
{
    /**
     * Mostrar detalle de proyecto.
     *
     * @param Request $request
     * @param Project|string $project  Project instance (route-model binding) or slug string
     */
    public function show(Request $request, Project|string $project)
    {
        Log::info('ProjectController@show called with project: ' . (is_string($project) ? $project : $project->slug));  
        // Accept either a Project instance (route-model binding) or a slug string.
        if (!($project instanceof Project)) {
            $project = Project::where('slug', $project)->firstOrFail();
        }

        // Increment views only once per session for this project
        $sessionKey = 'viewed_project_' . $project->id;
        if (!$request->session()->has($sessionKey)) {
            $project->increment('views_count');
            $request->session()->put($sessionKey, true);
            $project->refresh();
        }

        $project->load('services');
        $blocks = $project->blocks()->get();

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
        Log::info('Project: ' . json_encode($project, JSON_PRETTY_PRINT));
        Log::info('Project Blocks: ' . json_encode($blocks, JSON_PRETTY_PRINT));


        return view('project', compact('project', 'relatedProjects', 'blocks'));
    }

    /**
     * Alternar el like del proyecto por sesión.
     */
    public function like(Request $request, Project $project): RedirectResponse
    {
        $sessionKey = 'liked_project_' . $project->id;

        if ($request->session()->has($sessionKey)) {
            $project->decrement('likes_count', 1);
            $request->session()->forget($sessionKey);
        } else {
            $project->increment('likes_count');
            $request->session()->put($sessionKey, true);
        }

        return back();
    }
}
