<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $services = Service::all();

        $items = [
            ['title' => 'Neo-Glow Identity', 'grid_image_path' => 'https://picsum.photos/id/1011/800/1200', 'grid_image_size' => 3, 'published_at' => now()->subDays(10)],
            ['title' => 'Tech Legacy', 'grid_image_path' => 'https://picsum.photos/id/1012/800/800', 'grid_image_size' => 1, 'published_at' => now()->subDays(20)],
            ['title' => 'Vibe Shift', 'grid_image_path' => 'https://picsum.photos/id/1013/800/1000', 'grid_image_size' => 2, 'published_at' => now()->subDays(5)],
            ['title' => 'Luminal App', 'grid_image_path' => 'https://picsum.photos/id/1015/800/1000', 'grid_image_size' => 2, 'published_at' => now()->subDays(30)],
            ['title' => 'Void Space', 'grid_image_path' => 'https://picsum.photos/id/1016/800/1200', 'grid_image_size' => 3, 'published_at' => now()->subDays(2)],
            ['title' => 'Monolith Studio', 'grid_image_path' => 'https://picsum.photos/id/1018/800/800', 'grid_image_size' => 1, 'published_at' => now()->subDays(15)],
        ];

        foreach ($items as $i) {
            $project = Project::updateOrCreate(
                ['slug' => Str::slug($i['title'])],
                array_merge($i, ['description' => $i['title'] . ' — Caso de estudio.', 'is_active' => true, 'views_count' => 0, 'likes_count' => 0])
            );

            // Attach random services
            if ($services->count()) {
                $project->services()->sync($services->random(min(2, $services->count()))->pluck('id')->toArray());
            }
        }
    }
}
