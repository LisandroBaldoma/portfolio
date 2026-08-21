<?php

namespace App\Services;

use App\Models\Service;
use Illuminate\Database\Eloquent\Collection;

class ServiceService
{
    /**
     * Devuelve los servicios activos ordenados y con conteo de proyectos publicados y activos.
     */
    public function listForHome(): Collection
    {
        return Service::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->withCount(['projects as projects_count' => function ($q) {
                $q->where('is_active', true)->where('published_at', '<=', now());
            }])
            ->get();
    }
}
