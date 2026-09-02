<?php

namespace Tests\Unit;

use App\Services\ProjectUpdateService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProjectUpdateServiceTest extends TestCase
{
    public function test_it_stores_an_uploaded_image_when_real_path_is_unavailable(): void
    {
        Storage::fake('public');

        $temporaryPath = tempnam(sys_get_temp_dir(), 'project-image-');
        file_put_contents($temporaryPath, 'image contents');

        $image = new class($temporaryPath, 'project.jpg', 'image/jpeg', UPLOAD_ERR_OK, true) extends UploadedFile
        {
            public function getRealPath(): string|false
            {
                return false;
            }
        };

        try {
            $path = (new ProjectUpdateService())->storeImage($image, 'projects');

            Storage::disk('public')->assertExists($path);
            $this->assertStringStartsWith('projects/', $path);
        } finally {
            @unlink($temporaryPath);
        }
    }
}
