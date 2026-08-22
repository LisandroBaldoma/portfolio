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
        <label for="image_carousel" class="block text-sm font-medium mb-1">Imagen Carousel</label>
        <input id="image_carousel" name="image_carousel" type="file" accept="image/*"
            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 p-2">
        {{-- @error('image_carousel')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
        //TODO: mostrar imagen (si es formulario de editar)
        --}}
        @if($isEdit && !empty($project->carousel_image_path))
            <div class="mt-2">
                <img src="{{ $project->carousel_image_path }}" alt="carousel" class="w-48 h-auto rounded">
            </div>
        @endif
    </div>

    <div>
        <label for="grid_image" class="block text-sm font-medium mb-1">Imagen Grid</label>
        <input id="grid_image" name="grid_image" type="file" accept="image/*"
            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 p-2">
        {{-- @error('grid_image')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
        //TODO: mostrar imagen (si es formulario de editar)
        --}}
        @if($isEdit && !empty($project->grid_image_path))
            <div class="mt-2">
                <img src="{{ $project->grid_image_path }}" alt="grid" class="w-48 h-auto rounded">
            </div>
        @endif
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

@if ($isEdit)
    <div class="my-8 border-t border-gray-200 dark:border-gray-700"></div>

    <div x-data="{ showBlocks: false, blockType: 'title' }" class="space-y-4">
        <div class="flex items-center justify-between gap-3">
            <div>
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Bloques</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Agrega bloques adicionales dentro del mismo formulario.
                </p>
            </div>

            <button
                type="button"
                @click="showBlocks = !showBlocks"
                class="inline-flex items-center rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-slate-700 dark:bg-slate-100 dark:text-slate-900 dark:hover:bg-slate-300"
            >
                <span x-text="showBlocks ? 'Ocultar bloque' : 'Agregar bloque'"></span>
            </button>
        </div>

        <div x-show="showBlocks" x-transition class="space-y-6" style="display: none;">
            <div class="rounded-lg border border-gray-200 p-4 dark:border-gray-700">
                <div class="mb-4">
                    <h3 class="text-base font-medium text-gray-800 dark:text-gray-100">
                        Bloque 1
                    </h3>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="mb-1 block text-sm font-medium" for="block_content_type_1">
                            Tipo de Contenido
                        </label>

                        <select
                            id="block_content_type_1"
                            x-model="blockType"
                            name="block_content_types[]"
                            class="w-full rounded-md border-gray-300 p-2 dark:border-gray-700 dark:bg-gray-900"
                        >
                            <option value="title">Título</option>
                            <option value="text">Texto</option>
                            <option value="image">Imagen</option>
                        </select>
                    </div>

                    <div x-show="blockType === 'title'" x-transition>
                        <label class="mb-1 block text-sm font-medium" for="block_title_1">
                            Título
                        </label>

                        <input
                            id="block_title_1"
                            name="block_titles[]"
                            type="text"
                            class="w-full rounded-md border-gray-300 p-2 dark:border-gray-700 dark:bg-gray-900"
                        >
                    </div>

                    <div x-show="blockType === 'text'" x-transition>
                        <label class="mb-1 block text-sm font-medium" for="block_content_1">
                            Texto enriquecido
                        </label>

                        <textarea
                            id="block_content_1"
                            name="block_contents[]"
                            rows="5"
                            data-rich-text="true"
                            class="w-full rounded-md border-gray-300 p-2 dark:border-gray-700 dark:bg-gray-900"
                        ></textarea>
                    </div>

                    <div x-show="blockType === 'image'" x-transition>
                        <label class="mb-1 block text-sm font-medium" for="block_image_1">
                            Imagen
                        </label>

                        <input
                            id="block_image_1"
                            name="block_images[]"
                            type="file"
                            accept="image/*"
                            class="w-full rounded-md border-gray-300 p-2 dark:border-gray-700 dark:bg-gray-900"
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="mt-6 flex gap-3">
    <button type="submit"
        class="px-4 py-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white font-medium">{{ $isEdit ? 'Actualizar' : 'Crear' }}</button>
    {{-- <a href="{{ route('admin.projects.index') }}"
        class="px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700">Cancelar</a> --}}
</div>