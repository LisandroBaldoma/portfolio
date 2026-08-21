<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('services')->orderBy('published_at', 'desc')->get();
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $services = Service::orderBy('sort_order')->get();
        return view('admin.projects.create', compact('services'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:projects,slug',
            'description' => 'nullable|string',
            'grid_image' => 'nullable|image|max:5120',
            'image_carousel' => 'nullable|image|max:5120',
            'grid_image_size' => 'required|integer|min:1|max:3',
            'is_active' => 'required|boolean',
            'service_ids' => 'nullable|array',
            'service_ids.*' => 'exists:services,id',
        ]);

        $provided = $data['slug'] ?? null;
        $baseSlug = $provided ? Str::slug($provided) : Str::slug($data['title']);
        $slug = $this->makeUniqueSlug($baseSlug);

        // Handle file uploads
        if ($request->hasFile('grid_image')) {
            $path = $request->file('grid_image')->store('projects', 'public');
            $data['grid_image_path'] = Storage::url($path);
        }

        if ($request->hasFile('image_carousel')) {
            $path = $request->file('image_carousel')->store('projects', 'public');
            $data['carousel_image_path'] = Storage::url($path);
        }

        $project = Project::create(array_merge($data, ['slug' => $slug, 'published_at' => now()]));

        if (!empty($data['service_ids'])) {
            $project->services()->sync($data['service_ids']);
        }

        return redirect()->route('admin.projects.index')->with('success', 'Proyecto creado.');
    }

    public function edit(Project $project)
    {
        $services = Service::orderBy('sort_order')->get();
        // Reuse the existing 'create' view which includes the shared _form partial.
        // The form partial checks for an existing $project, so this avoids needing a separate edit view.
        return view('admin.projects.create', compact('project', 'services'));
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:projects,slug,' . $project->id,
            'description' => 'nullable|string',
            'grid_image' => 'nullable|image|max:5120',
            'image_carousel' => 'nullable|image|max:5120',
            'grid_image_size' => 'required|integer|min:1|max:3',
            'is_active' => 'required|boolean',
            'service_ids' => 'nullable|array',
            'service_ids.*' => 'exists:services,id',
        ]);

        $provided = $data['slug'] ?? null;
        $baseSlug = $provided ? Str::slug($provided) : Str::slug($data['title']);
        $slug = $this->makeUniqueSlug($baseSlug, $project->id);

        // Handle file uploads
        if ($request->hasFile('grid_image')) {
            $path = $request->file('grid_image')->store('projects', 'public');
            $data['grid_image_path'] = Storage::url($path);
        }

        if ($request->hasFile('image_carousel')) {
            $path = $request->file('image_carousel')->store('projects', 'public');
            $data['carousel_image_path'] = Storage::url($path);
        }

        $project->update(array_merge($data, ['slug' => $slug]));

        $project->services()->sync($data['service_ids'] ?? []);

        return redirect()->route('admin.projects.index')->with('success', 'Proyecto actualizado.');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Proyecto eliminado.');
    }

    /**
     * Generate a unique slug based on a base string. Optionally exclude a project id.
     */
    private function makeUniqueSlug(string $base, int $excludeId = null): string
    {
        $candidate = $base;
        $i = 1;

        while (Project::where('slug', $candidate)
            ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
            ->exists()) {
            $i++;
            $candidate = $base . '-' . $i;
        }

        return $candidate;
    }
}
