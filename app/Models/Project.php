<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'grid_image_path',
        'carousel_image_path',
        'published_at',
        'is_active',
        'views_count',
        'likes_count',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_active' => 'boolean',
        'views_count' => 'integer',
        'likes_count' => 'integer',
    ];

    public function getGridImagePathAttribute(?string $value): ?string
    {
        return $this->publicImageUrl($value);
    }

    public function getCarouselImagePathAttribute(?string $value): ?string
    {
        return $this->publicImageUrl($value);
    }

    private function publicImageUrl(?string $value): ?string
    {
        if (!$value) {
            return null;
        }

        $isAbsoluteUrl = str_starts_with($value, 'http');
        $path = $isAbsoluteUrl ? parse_url($value, PHP_URL_PATH) : $value;

        if (!is_string($path) || ($isAbsoluteUrl && !str_starts_with($path, '/storage/'))) {
            return $value;
        }

        $relativePath = str_starts_with($path, '/storage/')
            ? substr($path, strlen('/storage/'))
            : ltrim($path, '/');

        return asset('storage/' . ltrim($relativePath, '/'));
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'project_service')->withTimestamps();
    }

    public function blocks()
    {
        return $this->hasMany(ProjectBlock::class)->orderBy('sort_order');
    }
}
