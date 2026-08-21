<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['name' => 'Branding & Identity', 'icon' => 'fingerprint', 'description' => 'Estrategia de marca, identidad visual y naming para productos y servicios.', 'sort_order' => 1],
            ['name' => 'UI/UX Design', 'icon' => 'dashboard_customize', 'description' => 'Diseño de interfaces y experiencia orientada a conversiones y usabilidad.', 'sort_order' => 2],
            ['name' => 'AI Integrations', 'icon' => 'auto_awesome', 'description' => 'Integración de modelos ML/AI para automatización y mejora de productos.', 'sort_order' => 3],
            ['name' => 'Desarrollo Web', 'icon' => 'code', 'description' => 'Implementación fullstack con buenas prácticas y APIs escalables.', 'sort_order' => 4],
        ];

        foreach ($items as $i) {
            Service::updateOrCreate(
                ['slug' => Str::slug($i['name'])],
                array_merge($i, ['is_active' => true])
            );
        }
    }
}
