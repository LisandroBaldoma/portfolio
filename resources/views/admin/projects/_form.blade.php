@php
    $isEdit = isset($project);
    $selectedServices = old('service_ids', isset($project) ? $project->services->pluck('id')->toArray() : []);
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label for="title" class="block text-sm font-medium mb-1">Titulo</label>
        <input id="title" name="title" type="text" value="{{ old('title', $project->title ?? '') }}"
            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 p-2" required>
        {{-- @error('title')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror --}}
    </div>

    <div class="md:col-span-2">
        <label for="description" class="block text-sm font-medium mb-1">Contenido</label>
        <textarea id="description" name="description" rows="5"
            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 p-2">{{ old('description', $project->description ?? '') }}</textarea>
        {{-- @error('description')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror --}}
    </div>

    <div>
        <label for="grid_image" class="block text-sm font-medium mb-1">Imagen Grid</label>
        <input id="grid_image" name="grid_image" type="file" accept="image/*"
            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 p-2">
        @if($isEdit && !empty($project->grid_image_path))
            <div class="mt-2">
                <img src="{{ $project->grid_image_path }}" alt="{{ $project->title }}" class="w-48 h-auto rounded">
            </div>
        @endif
    </div>

    <div>
        <label for="image_carousel" class="block text-sm font-medium mb-1">Imagen Carousel</label>
        <input id="image_carousel" name="image_carousel" type="file" accept="image/*"
            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 p-2">
    </div>

    <div>
        <label for="grid_image_size" class="block text-sm font-medium mb-1">Tamano Grid</label>
        <select id="grid_image_size" name="grid_image_size"
            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 p-2" required>
            <option value="1" @selected(old('grid_image_size', $project->grid_image_size ?? '1') === '1')>1</option>
            <option value="2" @selected(old('grid_image_size', $project->grid_image_size ?? '1') === '2')>2</option>
            <option value="3" @selected(old('grid_image_size', $project->grid_image_size ?? '1') === '3')>3</option>
        </select>
        {{-- @error('grid_image_size')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror --}}
    </div>

    <div>
        <label for="is_active" class="block text-sm font-medium mb-1">Estado</label>
        <select id="is_active" name="is_active"
            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 p-2" required>
            <option value="1" @selected(old('is_active', (int) ($project->is_active ?? 1)) === 1)>Activo</option>
            <option value="0" @selected(old('is_active', (int) ($project->is_active ?? 1)) === 0)>Inactivo</option>
        </select>
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium mb-2">Servicios Asociados</label>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
            @foreach($services as $svc)
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="service_ids[]" value="{{ $svc->id }}" @checked(in_array($svc->id, $selectedServices)) class="rounded">
                    <span class="text-sm">{{ $svc->name }}</span>
                </label>
            @endforeach
        </div>
        {{-- @error('service_ids')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
        @error('service_ids.*')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror --}}
    </div>
</div>

<div class="my-8 border-t border-gray-200 dark:border-gray-700"></div>

<div
    x-data="{
        showBlocks: false,
        newBlocks: [],
        deletedBlocks: [],
        existingBlocks: {{ isset($blocks) ? $blocks->count() : 0 }}
    }"
    class="space-y-4"
>
        <div class="flex items-center justify-between gap-3">
            <div>
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Bloques</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Edita los bloques existentes o agrega nuevos bloques.
                </p>
            </div>
        </div>

        <div class="space-y-3">
            @forelse($blocks ?? [] as $blockIndex => $block)
                @php
                    $blockData = $block->data ?? [];
                    $blockImage = $blockData['image'] ?? [];
                    $blockImagePath = ltrim(str_replace('/storage/', '', $blockImage['url'] ?? ''), '/');
                    $blockImageUrl = $blockImagePath && Storage::disk('public')->exists($blockImagePath)
                        ? asset('storage/' . $blockImagePath)
                        : null;
                @endphp

                <div
                    x-show="!deletedBlocks.includes({{ $block->id }})"
                    class="rounded-lg border border-gray-200 p-4 dark:border-gray-700"
                >
                    <div class="mb-4 flex items-center justify-between gap-3">
                        <h3 class="text-base font-medium text-gray-800 dark:text-gray-100">
                            Bloque {{ $blockIndex + 1 }}
                        </h3>
                        <button
                            type="button"
                            @click="deletedBlocks.push({{ $block->id }})"
                            class="text-red-600 transition hover:text-red-800"
                            title="Eliminar bloque"
                            aria-label="Eliminar bloque"
                        >
                            @svg('fas-trash', 'h-5 w-5')
                        </button>
                    </div>

                    <input
                        type="hidden"
                        name="block_delete_ids[]"
                        value="{{ $block->id }}"
                        :disabled="!deletedBlocks.includes({{ $block->id }})"
                    >
                    <input type="hidden" name="block_ids[{{ $blockIndex }}]" value="{{ $block->id }}">
                    <input type="hidden" name="block_existing_images[{{ $blockIndex }}]" value="{{ $blockImagePath }}">

                    <div class="grid grid-cols-1 gap-4">
                        <div x-data="{ editing: false }" x-init="window.initRichTextEditor($el)">
                            <label class="mb-1 block text-sm font-medium">Título</label>
                            <div x-show="!editing" class="flex items-center justify-between rounded-md border border-gray-300 p-2 dark:border-gray-700 dark:bg-gray-900">
                                <span class="truncate">{{ strip_tags(old('block_titles.' . $blockIndex, $blockData['title'] ?? '')) ?: 'Sin título' }}</span>
                                <button type="button" @click="editing = true" class="ml-3 text-sm text-blue-600 hover:text-blue-800">Editar</button>
                            </div>
                            <div x-show="editing" x-cloak>
                            <div class="mb-2 flex flex-wrap gap-1 rounded-t-md border border-b-0 border-gray-300 bg-gray-50 p-2 dark:border-gray-700 dark:bg-gray-800">
                                <button type="button" data-command="bold" class="rounded px-2 py-1 text-sm font-bold hover:bg-gray-200 dark:hover:bg-gray-700" title="Negrita">B</button>
                                <button type="button" data-command="italic" class="rounded px-2 py-1 text-sm italic hover:bg-gray-200 dark:hover:bg-gray-700" title="Cursiva">I</button>
                                <button type="button" data-command="underline" class="rounded px-2 py-1 text-sm underline hover:bg-gray-200 dark:hover:bg-gray-700" title="Subrayado">U</button>
                                <button type="button" data-command="insertUnorderedList" class="rounded px-2 py-1 text-sm hover:bg-gray-200 dark:hover:bg-gray-700" title="Lista">&#8226;</button>
                                <button type="button" data-command="createLink" class="rounded px-2 py-1 text-sm hover:bg-gray-200 dark:hover:bg-gray-700" title="Enlace">&#128279;</button>
                                <select data-command="fontSize" class="rounded border-gray-300 px-1 py-1 text-sm dark:border-gray-600 dark:bg-gray-900" title="Tamaño">
                                    <option value="3">Tamaño</option>
                                    <option value="2">Pequeño</option>
                                    <option value="4">Mediano</option>
                                    <option value="5">Grande</option>
                                    <option value="7">Extra grande</option>
                                </select>
                                <input type="color" data-command="foreColor" value="#111827" class="h-8 w-8 cursor-pointer rounded border border-gray-300 p-1 dark:border-gray-600" title="Color">
                            </div>
                            <input type="hidden" name="block_titles[{{ $blockIndex }}]" value="{{ old('block_titles.' . $blockIndex, $blockData['title'] ?? '') }}">
                            <div
                                contenteditable="true"
                                role="textbox"
                                aria-label="Título"
                                class="min-h-10 w-full rounded-b-md border border-gray-300 p-2 dark:border-gray-700 dark:bg-gray-900"
                            >{!! old('block_titles.' . $blockIndex, $blockData['title'] ?? '') !!}</div>
                            </div>
                        </div>

                        <div x-data="{ editing: false }" x-init="window.initRichTextEditor($el)">
                            <label class="mb-1 block text-sm font-medium" for="block_subtitle_{{ $blockIndex }}">Subtítulo</label>
                            <div x-show="!editing" class="flex items-center justify-between rounded-md border border-gray-300 p-2 dark:border-gray-700 dark:bg-gray-900">
                                <span class="truncate">{{ strip_tags(old('block_subtitles.' . $blockIndex, $blockData['subtitle'] ?? '')) ?: 'Sin subtítulo' }}</span>
                                <button type="button" @click="editing = true" class="ml-3 text-sm text-blue-600 hover:text-blue-800">Editar</button>
                            </div>
                            <div x-show="editing" x-cloak>
                                <div class="mb-2 flex flex-wrap gap-1 rounded-t-md border border-b-0 border-gray-300 bg-gray-50 p-2 dark:border-gray-700 dark:bg-gray-800">
                                    <button type="button" data-command="bold" class="rounded px-2 py-1 text-sm font-bold hover:bg-gray-200 dark:hover:bg-gray-700" title="Negrita">B</button>
                                    <button type="button" data-command="italic" class="rounded px-2 py-1 text-sm italic hover:bg-gray-200 dark:hover:bg-gray-700" title="Cursiva">I</button>
                                    <button type="button" data-command="underline" class="rounded px-2 py-1 text-sm underline hover:bg-gray-200 dark:hover:bg-gray-700" title="Subrayado">U</button>
                                    <select data-command="fontSize" class="rounded border-gray-300 px-1 py-1 text-sm dark:border-gray-600 dark:bg-gray-900" title="Tamaño">
                                        <option value="3">Tamaño</option><option value="2">Pequeño</option><option value="4">Mediano</option><option value="5">Grande</option><option value="7">Extra grande</option>
                                    </select>
                                    <input type="color" data-command="foreColor" value="#111827" class="h-8 w-8 cursor-pointer rounded border border-gray-300 p-1 dark:border-gray-600" title="Color">
                                </div>
                                <input type="hidden" name="block_subtitles[{{ $blockIndex }}]" value="{{ old('block_subtitles.' . $blockIndex, $blockData['subtitle'] ?? '') }}">
                                <div contenteditable="true" role="textbox" aria-label="Subtítulo" class="min-h-10 w-full rounded-b-md border border-gray-300 p-2 dark:border-gray-700 dark:bg-gray-900">{!! old('block_subtitles.' . $blockIndex, $blockData['subtitle'] ?? '') !!}</div>
                            </div>
                        </div>

                        <div x-data="{ editing: false }" x-init="window.initRichTextEditor($el)">
                            <label class="mb-1 block text-sm font-medium" for="block_content_{{ $blockIndex }}">Contenido</label>
                            <div x-show="!editing" class="flex items-center justify-between rounded-md border border-gray-300 p-2 dark:border-gray-700 dark:bg-gray-900">
                                <span class="line-clamp-2">{{ strip_tags(old('block_contents.' . $blockIndex, $blockData['text'] ?? '')) ?: 'Sin contenido' }}</span>
                                <button type="button" @click="editing = true" class="ml-3 shrink-0 text-sm text-blue-600 hover:text-blue-800">Editar</button>
                            </div>
                            <div x-show="editing" x-cloak>
                            <div>
                                <div class="mb-2 flex flex-wrap gap-1 rounded-t-md border border-b-0 border-gray-300 bg-gray-50 p-2 dark:border-gray-700 dark:bg-gray-800">
                                    <button type="button" data-command="bold" class="rounded px-2 py-1 text-sm font-bold hover:bg-gray-200 dark:hover:bg-gray-700" title="Negrita">B</button>
                                    <button type="button" data-command="italic" class="rounded px-2 py-1 text-sm italic hover:bg-gray-200 dark:hover:bg-gray-700" title="Cursiva">I</button>
                                    <button type="button" data-command="underline" class="rounded px-2 py-1 text-sm underline hover:bg-gray-200 dark:hover:bg-gray-700" title="Subrayado">U</button>
                                    <button type="button" data-command="insertUnorderedList" class="rounded px-2 py-1 text-sm hover:bg-gray-200 dark:hover:bg-gray-700" title="Lista">&#8226;</button>
                                    <button type="button" data-command="createLink" class="rounded px-2 py-1 text-sm hover:bg-gray-200 dark:hover:bg-gray-700" title="Enlace">&#128279;</button>
                                    <select data-command="fontSize" class="rounded border-gray-300 px-1 py-1 text-sm dark:border-gray-600 dark:bg-gray-900" title="Tamaño">
                                        <option value="3">Tamaño</option>
                                        <option value="2">Pequeño</option>
                                        <option value="4">Mediano</option>
                                        <option value="5">Grande</option>
                                        <option value="7">Extra grande</option>
                                    </select>
                                    <input type="color" data-command="foreColor" value="#111827" class="h-8 w-8 cursor-pointer rounded border border-gray-300 p-1 dark:border-gray-600" title="Color">
                                </div>
                                <input type="hidden" name="block_contents[{{ $blockIndex }}]" value="{{ old('block_contents.' . $blockIndex, $blockData['text'] ?? '') }}">
                                <div contenteditable="true" role="textbox" aria-label="Contenido" class="min-h-32 w-full rounded-b-md border border-gray-300 p-2 dark:border-gray-700 dark:bg-gray-900">{!! old('block_contents.' . $blockIndex, $blockData['text'] ?? '') !!}</div>
                            </div>
                            </div>
                        </div>

                        <div>                           
                            <label class="mb-1 mt-3 block text-sm font-medium" for="block_image_{{ $blockIndex }}">Reemplazar imagen</label>
                            <input
                                id="block_image_{{ $blockIndex }}"
                                name="block_images[{{ $blockIndex }}]"
                                type="file"
                                accept="image/*"
                                class="w-full rounded-md border-gray-300 p-2 dark:border-gray-700 dark:bg-gray-900"
                            >
                            @if($blockImageUrl)
                                <img src="{{ $blockImageUrl }}" alt="{{ $block->data['title'] ?? 'Imagen del bloque' }}" class="mt-2 h-32 w-full rounded object-cover">
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <p class="rounded-lg border border-dashed border-gray-300 p-4 text-sm text-gray-500 dark:border-gray-700 dark:text-gray-400">
                    Este proyecto todavía no tiene bloques.
                </p>
            @endforelse
        </div>

        <div class="flex justify-end">
            <button
                type="button"
                @click="newBlocks.push({}); showBlocks = true"
                class="inline-flex items-center rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-slate-700 dark:bg-slate-100 dark:text-slate-900 dark:hover:bg-slate-300"
            >
                Agregar bloque
            </button>
        </div>

        <div x-show="showBlocks" x-transition class="space-y-6" style="display: none;">
            <template x-for="(newBlock, index) in newBlocks" :key="index">
                <div class="rounded-lg border border-gray-200 p-4 dark:border-gray-700">
                    <div class="mb-4 flex items-center justify-between gap-3">
                        <h3 class="text-base font-medium text-gray-800 dark:text-gray-100">
                            Bloque nuevo <span x-text="existingBlocks + index + 1"></span>
                        </h3>
                        <button type="button" @click="newBlocks.splice(index, 1)" class="text-sm text-red-600 hover:text-red-800">
                            Quitar
                        </button>
                    </div>

                    <div class="grid grid-cols-1 gap-4">
                        <div x-data="{ editing: false }" x-init="window.initRichTextEditor($el)">
                            <label class="mb-1 block text-sm font-medium">Título</label>
                            <div x-show="!editing" class="flex items-center justify-between rounded-md border border-gray-300 p-2 dark:border-gray-700 dark:bg-gray-900">
                                <span class="truncate">Sin título</span>
                                <button type="button" @click="editing = true" class="ml-3 text-sm text-blue-600 hover:text-blue-800">Editar</button>
                            </div>
                            <div x-show="editing" x-cloak>
                            <div class="mb-2 flex flex-wrap gap-1 rounded-t-md border border-b-0 border-gray-300 bg-gray-50 p-2 dark:border-gray-700 dark:bg-gray-800">
                                <button type="button" data-command="bold" class="rounded px-2 py-1 text-sm font-bold hover:bg-gray-200 dark:hover:bg-gray-700" title="Negrita">B</button>
                                <button type="button" data-command="italic" class="rounded px-2 py-1 text-sm italic hover:bg-gray-200 dark:hover:bg-gray-700" title="Cursiva">I</button>
                                <button type="button" data-command="underline" class="rounded px-2 py-1 text-sm underline hover:bg-gray-200 dark:hover:bg-gray-700" title="Subrayado">U</button>
                                <button type="button" data-command="insertUnorderedList" class="rounded px-2 py-1 text-sm hover:bg-gray-200 dark:hover:bg-gray-700" title="Lista">&#8226;</button>
                                <button type="button" data-command="createLink" class="rounded px-2 py-1 text-sm hover:bg-gray-200 dark:hover:bg-gray-700" title="Enlace">&#128279;</button>
                                <select data-command="fontSize" class="rounded border-gray-300 px-1 py-1 text-sm dark:border-gray-600 dark:bg-gray-900" title="Tamaño">
                                    <option value="3">Tamaño</option>
                                    <option value="2">Pequeño</option>
                                    <option value="4">Mediano</option>
                                    <option value="5">Grande</option>
                                    <option value="7">Extra grande</option>
                                </select>
                                <input type="color" data-command="foreColor" value="#111827" class="h-8 w-8 cursor-pointer rounded border border-gray-300 p-1 dark:border-gray-600" title="Color">
                            </div>
                            <input type="hidden" :name="`block_titles[new_${index}]`" value="">
                            <div contenteditable="true" role="textbox" aria-label="Título" class="min-h-10 w-full rounded-b-md border border-gray-300 p-2 dark:border-gray-700 dark:bg-gray-900"></div>
                            </div>
                        </div>

                        <div x-data="{ editing: false }" x-init="window.initRichTextEditor($el)">
                            <label class="mb-1 block text-sm font-medium">Subtítulo</label>
                            <div x-show="!editing" class="flex items-center justify-between rounded-md border border-gray-300 p-2 dark:border-gray-700 dark:bg-gray-900">
                                <span class="truncate">Sin subtítulo</span>
                                <button type="button" @click="editing = true" class="ml-3 text-sm text-blue-600 hover:text-blue-800">Editar</button>
                            </div>
                            <div x-show="editing" x-cloak>
                                <input type="hidden" :name="`block_subtitles[new_${index}]`" value="">
                                <div contenteditable="true" role="textbox" aria-label="Subtítulo" class="min-h-10 w-full rounded-md border border-gray-300 p-2 dark:border-gray-700 dark:bg-gray-900"></div>
                            </div>
                        </div>

                        <div x-data="{ editing: false }" x-init="window.initRichTextEditor($el)">
                            <label class="mb-1 block text-sm font-medium">Contenido</label>
                            <div x-show="!editing" class="flex items-center justify-between rounded-md border border-gray-300 p-2 dark:border-gray-700 dark:bg-gray-900">
                                <span class="line-clamp-2">Sin contenido</span>
                                <button type="button" @click="editing = true" class="ml-3 shrink-0 text-sm text-blue-600 hover:text-blue-800">Editar</button>
                            </div>
                            <div x-show="editing" x-cloak>
                            <div>
                                <div class="mb-2 flex flex-wrap gap-1 rounded-t-md border border-b-0 border-gray-300 bg-gray-50 p-2 dark:border-gray-700 dark:bg-gray-800">
                                    <button type="button" data-command="bold" class="rounded px-2 py-1 text-sm font-bold hover:bg-gray-200 dark:hover:bg-gray-700" title="Negrita">B</button>
                                    <button type="button" data-command="italic" class="rounded px-2 py-1 text-sm italic hover:bg-gray-200 dark:hover:bg-gray-700" title="Cursiva">I</button>
                                    <button type="button" data-command="underline" class="rounded px-2 py-1 text-sm underline hover:bg-gray-200 dark:hover:bg-gray-700" title="Subrayado">U</button>
                                    <button type="button" data-command="insertUnorderedList" class="rounded px-2 py-1 text-sm hover:bg-gray-200 dark:hover:bg-gray-700" title="Lista">&#8226;</button>
                                    <button type="button" data-command="createLink" class="rounded px-2 py-1 text-sm hover:bg-gray-200 dark:hover:bg-gray-700" title="Enlace">&#128279;</button>
                                    <select data-command="fontSize" class="rounded border-gray-300 px-1 py-1 text-sm dark:border-gray-600 dark:bg-gray-900" title="Tamaño">
                                        <option value="3">Tamaño</option>
                                        <option value="2">Pequeño</option>
                                        <option value="4">Mediano</option>
                                        <option value="5">Grande</option>
                                        <option value="7">Extra grande</option>
                                    </select>
                                    <input type="color" data-command="foreColor" value="#111827" class="h-8 w-8 cursor-pointer rounded border border-gray-300 p-1 dark:border-gray-600" title="Color">
                                </div>
                                <input type="hidden" :name="`block_contents[new_${index}]`" value="">
                                <div contenteditable="true" role="textbox" aria-label="Contenido" class="min-h-32 w-full rounded-b-md border border-gray-300 p-2 dark:border-gray-700 dark:bg-gray-900"></div>
                            </div>
                            </div>
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium">Imagen</label>
                            <input type="file" :name="`block_images[new_${index}]`" accept="image/*" class="w-full rounded-md border-gray-300 p-2 dark:border-gray-700 dark:bg-gray-900">
                        </div>
                    </div>
                </div>
            </template>

        </div>
    </div>
</div>

<div class="mt-6 flex gap-3">
    <button type="submit"
        class="px-4 py-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white font-medium">{{ $isEdit ? 'Actualizar' : 'Crear' }}</button>
    {{-- <a href="{{ route('admin.projects.index') }}"
        class="px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700">Cancelar</a> --}}
</div>