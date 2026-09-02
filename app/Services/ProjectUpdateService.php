<?php

namespace App\Services;

use App\Models\Project;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use RuntimeException;

class ProjectUpdateService
{
    /**
     * Actualiza un proyecto con todos sus datos relacionados (proyecto, servicios, bloques).
     *
     * @param Project $project
     * @param array $data Los datos validados del request
     * @param UploadedFile|null $gridImage
     * @param UploadedFile|null $carouselImage
     * @param array|null $blockImages Array de imágenes de bloques indexadas por índice
     * @return Project
     */
    public function update(
        Project $project,
        array $data,
        ?UploadedFile $gridImage = null,
        ?UploadedFile $carouselImage = null,
        ?array $blockImages = null
    ): Project {
        // Procesar slug
        $provided = $data['slug'] ?? null;
        $baseSlug = $provided ? Str::slug($provided) : Str::slug($data['title']);
        $slug = $this->makeUniqueSlug($baseSlug, $project->id);

        // Procesar imágenes
        if ($gridImage) {
            $path = $this->storeImage($gridImage, 'projects');
            $data['grid_image_path'] = $path;
        }

        if ($carouselImage) {
            $path = $this->storeImage($carouselImage, 'projects');
            $data['carousel_image_path'] = $path;
        }

        // Actualizar proyecto
        $project->update(array_merge($data, ['slug' => $slug]));

        // Actualizar servicios relacionados
        $project->services()->sync($data['service_ids'] ?? []);

        // Actualizar bloques de contenido
        $this->updateProjectBlocks($project, $data, $blockImages);

        return $project;
    }

    /**
     * Actualiza los bloques existentes y crea los nuevos enviados en el formulario.
     *
     * @param Project $project
     * @param array $data
     * @param array|null $blockImages Array de imágenes indexadas como los campos del formulario
     * @return void
     */
    public function updateProjectBlocks(Project $project, array $data, ?array $blockImages = null): void
    {
        $blockTitles = $data['block_titles'] ?? [];
        $blockSubtitles = $data['block_subtitles'] ?? [];
        $blockContents = $data['block_contents'] ?? [];
        $blockIds = $data['block_ids'] ?? [];
        $blockDeleteIds = $data['block_delete_ids'] ?? [];
        $existingImages = $data['block_existing_images'] ?? [];

        if (
            empty($blockTitles) &&
            empty($blockSubtitles) &&
            empty($blockContents) &&
            empty($blockImages) &&
            empty($blockDeleteIds)
        ) {
            return;
        }

        $project->blocks()->whereIn('id', $blockDeleteIds)->delete();

        $nextSortOrder = ((int) $project->blocks()->max('sort_order')) + 1;
        $indexes = array_unique(array_merge(
            array_keys($blockTitles),
            array_keys($blockSubtitles),
            array_keys($blockContents),
            array_keys($blockImages ?? []),
            array_keys($blockIds)
        ));

        foreach ($indexes as $index) {
            $blockId = $blockIds[$index] ?? null;

            if ($blockId && in_array((int) $blockId, array_map('intval', $blockDeleteIds), true)) {
                continue;
            }

            $title = $blockTitles[$index] ?? '';
            $content = $blockContents[$index] ?? '';
            $blockImage = $blockImages[$index] ?? null;
            $imageUrl = $existingImages[$index] ?? '';
            $imagePath = ltrim(str_replace('/storage/', '', $imageUrl), '/');
            $existingBlock = $blockId
                ? $project->blocks()->whereKey($blockId)->first()
                : null;
            $subtitle = $blockSubtitles[$index] ?? ($existingBlock?->data['subtitle'] ?? '');
            $imageAlt = $existingBlock?->data['image']['alt'] ?? '';

            if ($blockImage instanceof UploadedFile) {
                $path = $this->storeImage($blockImage, 'projects/blocks');
                $imagePath = $path;
            }

            $blockData = [
                'title' => $title,
                'subtitle' => $subtitle,
                'text' => $content,
                'image' => [
                    'url' => $imagePath,
                    'alt' => $imageAlt,
                ],
            ];

            if ($existingBlock) {
                $existingBlock->update([
                    'data' => $blockData,
                    'sort_order' => $index,
                ]);
                continue;
            }

            $project->blocks()->create([
                'data' => $blockData,
                'sort_order' => $nextSortOrder++,
            ]);
        }
    }

    public function storeImage(UploadedFile $image, string $directory): string
    {
        if (!$image->isValid() || !is_readable($image->getPathname())) {
            throw ValidationException::withMessages([
                'images' => 'La imagen no se pudo cargar. Inténtalo nuevamente.',
            ]);
        }

        $path = trim($directory, '/') . '/' . $image->hashName();
        $stream = fopen($image->getPathname(), 'r');

        if ($stream === false) {
            throw ValidationException::withMessages([
                'images' => 'La imagen no se pudo leer. Inténtalo nuevamente.',
            ]);
        }

        try {
            $stored = Storage::disk('public')->put($path, $stream);
        } finally {
            if (is_resource($stream)) {
                fclose($stream);
            }
        }

        if (!$stored) {
            throw new RuntimeException('No se pudo guardar la imagen en el disco público.');
        }

        return $path;
    }

    /**
     * Genera un slug único basado en una cadena base. Opcionalmente excluye un ID de proyecto.
     *
     * @param string $base
     * @param int|null $excludeId
     * @return string
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
