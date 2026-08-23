<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProjectBlock extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'data',
        'sort_order',
    ];

    protected $casts = [
        'data' => 'json',
        'sort_order' => 'integer',
    ];

    public function safeTitleHtml(): string
    {
        return $this->safeHtml(data_get($this->data, 'title', ''));
    }

    public function safeSubtitleHtml(): string
    {
        return $this->safeHtml(data_get($this->data, 'subtitle', ''));
    }

    public function safeTextHtml(): string
    {
        return $this->safeHtml(data_get($this->data, 'text', ''));
    }

    public function imageUrl(): ?string
    {
        $value = data_get($this->data, 'image.url');

        if (!$value) {
            return null;
        }

        $path = str_starts_with($value, 'http')
            ? parse_url($value, PHP_URL_PATH)
            : $value;

        if (!is_string($path)) {
            return null;
        }

        if (str_starts_with($path, '/storage/')) {
            $path = substr($path, strlen('/storage/'));
        }

        $path = ltrim($path, '/');

        if (str_starts_with($value, 'http') && !str_starts_with($value, config('app.url'))) {
            return $value;
        }

        return Storage::disk('public')->exists($path)
            ? asset('storage/' . $path)
            : null;
    }

    private function safeHtml(mixed $value): string
    {
        $title = (string) $value;
        $title = strip_tags($title, '<b><strong><i><em><u><span><font><br><p><ul><ol><li><a>');

        return preg_replace_callback(
            '/<(b|strong|i|em|u|span|font|p|ul|ol|li|a)(?:\s[^>]*)?>/i',
            function (array $match): string {
                $tag = strtolower($match[1]);
                $attributes = $match[0];
                $styles = [];

                if ($tag === 'a' && preg_match('/href\s*=\s*["\'](https?:\/\/[^"\']+)["\']/i', $attributes, $href)) {
                    return '<a href="' . e($href[1]) . '" target="_blank" rel="noopener noreferrer">';
                }

                if ($tag === 'a') {
                    return '<a>';
                }

                $hasColorAttribute = preg_match('/color\s*=\s*["\']?(#[0-9a-f]{3,8})/i', $attributes, $color);
                $hasColorStyle = preg_match('/style\s*=\s*["\'][^"\']*color\s*:\s*(#[0-9a-f]{3,8})/i', $attributes, $styleColor);

                if ($hasColorAttribute || $hasColorStyle) {
                    $colorValue = $hasColorAttribute ? $color[1] : $styleColor[1];
                    $styles[] = 'color:' . strtolower($colorValue);
                }

                if (preg_match('/size\s*=\s*["\']?([1-7])/i', $attributes, $size)) {
                    $fontSizes = [1 => '0.75rem', 2 => '0.875rem', 3 => '1rem', 4 => '1.125rem', 5 => '1.25rem', 6 => '1.5rem', 7 => '2rem'];
                    $styles[] = 'font-size:' . $fontSizes[(int) $size[1]];
                }

                return '<' . $tag . ($styles ? ' style="' . implode(';', $styles) . '"' : '') . '>';
            },
            $title
        ) ?? '';
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
