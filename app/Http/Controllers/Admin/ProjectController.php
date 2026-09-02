<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Service;
use App\Services\ProjectUpdateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
            'production_url' => 'nullable|url|max:255',
            'technologies' => 'nullable|string|max:255',
            'grid_image' => 'nullable|image|max:5120',
            'image_carousel' => 'nullable|image|max:5120',
            'grid_image_size' => 'required|integer|min:1|max:3',
            'is_active' => 'required|boolean',
            'service_ids' => 'nullable|array',
            'service_ids.*' => 'exists:services,id',
            'block_ids' => 'nullable|array',
            'block_ids.*' => 'integer|exists:project_blocks,id',
            'block_delete_ids' => 'nullable|array',
            'block_delete_ids.*' => 'integer|exists:project_blocks,id',
            'block_existing_images' => 'nullable|array',
            'block_existing_images.*' => 'nullable|string',
            'block_titles' => 'nullable|array',
            'block_titles.*' => 'nullable|string',
            'block_subtitles' => 'nullable|array',
            'block_subtitles.*' => 'nullable|string|max:255',
            'block_contents' => 'nullable|array',
            'block_contents.*' => 'nullable|string',
            'block_images' => 'nullable|array',
            'block_images.*' => 'nullable|image|max:5120',
        ]);

        $provided = $data['slug'] ?? null;
        $baseSlug = $provided ? Str::slug($provided) : Str::slug($data['title']);
        $slug = $this->makeUniqueSlug($baseSlug);
        $service = new ProjectUpdateService();

        // Handle file uploads
        if ($request->hasFile('grid_image')) {
            $path = $service->storeImage($request->file('grid_image'), 'projects');
            $data['grid_image_path'] = $path;
        }

        if ($request->hasFile('image_carousel')) {
            $path = $service->storeImage($request->file('image_carousel'), 'projects');
            $data['carousel_image_path'] = $path;
        }

        $project = Project::create(array_merge($data, ['slug' => $slug, 'published_at' => now()]));

        if (!empty($data['service_ids'])) {
            $project->services()->sync($data['service_ids']);
        }

        // Procesar bloques de contenido si existen
        $service->updateProjectBlocks($project, $data, $request->file('block_images'));

        return redirect()->route('admin.projects.index')->with('success', 'Proyecto creado.');
    }

    public function edit(Project $project)
    {
        Log::info('Editing project: ' . $project->id);
        $services = Service::orderBy('sort_order')->get();
        $blocks = $project->blocks;
        Log::info('Project blocks: ' . json_encode($blocks, JSON_PRETTY_PRINT));
        Log::info('Project services: ' . json_encode($project->services, JSON_PRETTY_PRINT));
        Log::info('Project data: ' . json_encode($project->toArray(), JSON_PRETTY_PRINT));
        // Reuse the existing 'create' view which includes the shared _form partial.
        // The form partial checks for an existing $project, so this avoids needing a separate edit view.
        return view('admin.projects.create', compact('project', 'services', 'blocks'));
    }

    public function update(Request $request, Project $project)
    {
        Log::info('Updating project: ' . $project->id);
        Log::info('Request data: ' . json_encode($request->all(), JSON_PRETTY_PRINT));

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:projects,slug,' . $project->id,
            'description' => 'nullable|string',
            'production_url' => 'nullable|url|max:255',
            'technologies' => 'nullable|string|max:255',
            'grid_image' => 'nullable|image|max:5120',
            'image_carousel' => 'nullable|image|max:5120',
            'grid_image_size' => 'required|integer|min:1|max:3',
            'is_active' => 'required|boolean',
            'service_ids' => 'nullable|array',
            'service_ids.*' => 'exists:services,id',
            'block_ids' => 'nullable|array',
            'block_ids.*' => 'integer|exists:project_blocks,id',
            'block_delete_ids' => 'nullable|array',
            'block_delete_ids.*' => 'integer|exists:project_blocks,id',
            'block_existing_images' => 'nullable|array',
            'block_existing_images.*' => 'nullable|string',
            'block_titles' => 'nullable|array',
            'block_titles.*' => 'nullable|string',
            'block_subtitles' => 'nullable|array',
            'block_subtitles.*' => 'nullable|string|max:255',
            'block_contents' => 'nullable|array',
            'block_contents.*' => 'nullable|string',
            'block_images' => 'nullable|array',
            'block_images.*' => 'nullable|image|max:5120',
        ]);

        // Usar el Service para actualizar el proyecto y todas sus relaciones
        $service = new ProjectUpdateService();
        $service->update(
            $project,
            $data,
            $request->file('grid_image'),
            $request->file('image_carousel'),
            $request->file('block_images') // Pasar las imágenes de bloques
        );

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
    private function makeUniqueSlug(string $base, ?int $excludeId = null): string
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
