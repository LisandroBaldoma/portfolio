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

<div class="mt-6 flex gap-3">
    <button type="submit"
        class="px-4 py-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white font-medium">{{ $isEdit ? 'Actualizar' : 'Crear' }}</button>
    {{-- <a href="{{ route('admin.projects.index') }}"
        class="px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700">Cancelar</a> --}}
</div>