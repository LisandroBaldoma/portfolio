<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('project_blocks')
            ->orderBy('project_id')
            ->orderBy('sort_order')
            ->get()
            ->groupBy('project_id')
            ->each(function ($blocks): void {
                $firstBlock = $blocks->first();
                $data = [];

                foreach ($blocks as $block) {
                    $blockData = json_decode($block->data, true) ?: [];

                    if ($block->type === 'title') {
                        $data['title'] = $blockData['text'] ?? '';
                    }

                    if ($block->type === 'text') {
                        $data['text'] = $blockData['html'] ?? '';
                    }

                    if ($block->type === 'image') {
                        $data['image'] = [
                            'url' => $blockData['url'] ?? '',
                            'alt' => $blockData['alt'] ?? '',
                        ];
                    }
                }

                DB::table('project_blocks')
                    ->where('id', $firstBlock->id)
                    ->update(['data' => json_encode($data)]);

                DB::table('project_blocks')
                    ->where('project_id', $firstBlock->project_id)
                    ->where('id', '!=', $firstBlock->id)
                    ->delete();
            });

        Schema::table('project_blocks', function (Blueprint $table): void {
            $table->dropUnique('project_blocks_project_id_type_unique');
            $table->dropColumn('type');
        });
    }

    public function down(): void
    {
        Schema::table('project_blocks', function (Blueprint $table): void {
            $table->enum('type', ['title', 'text', 'image'])->default('text')->after('project_id');
            $table->unique(['project_id', 'type']);
        });
    }
};
