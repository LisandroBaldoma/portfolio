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

    public function services()
    {
        return $this->belongsToMany(Service::class, 'project_service')->withTimestamps();
    }
}
