@php
    $isEdit = isset($service);
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label for="name" class="block text-sm font-medium mb-1">Nombre</label>
        <input id="name" name="name" type="text" value="{{ old('name', $service->name ?? '') }}"
            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900" required>
        @error('name')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="slug" class="block text-sm font-medium mb-1">Slug</label>
        <input id="slug" name="slug" type="text" value="{{ old('slug', $service->slug ?? '') }}"
            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900" required>
        @error('slug')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        <label for="description" class="block text-sm font-medium mb-1">Descripción</label>
        <textarea id="description" name="description" rows="4"
            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900">{{ old('description', $service->description ?? '') }}</textarea>
        @error('description')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="icon" class="block text-sm font-medium mb-1">Ícono (Material Symbol)</label>
           <input id="icon" name="icon" type="text" value="{{ old('icon', $service->icon ?? '') }}"
              class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900"
              placeholder="fingerprint">
          @error('icon')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
          @enderror
    </div>

    <div>
        <label for="sort_order" class="block text-sm font-medium mb-1">Orden</label>
        <input id="sort_order" name="sort_order" type="number" min="0"
            value="{{ old('sort_order', $service->sort_order ?? 0) }}"
            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900" required>
        @error('sort_order')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="is_active" class="block text-sm font-medium mb-1">Estado</label>
        <select id="is_active" name="is_active"
            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900" required>
            <option value="1" {{ old('is_active', $service->is_active ?? 1) ? 'selected' : '' }}>Activo</option>
            <option value="0" {{ !old('is_active', $service->is_active ?? 1) ? 'selected' : '' }}>Inactivo</option>
        </select>
        @error('is_active')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mt-6 flex gap-3">
    <button type="submit"
        class="px-4 py-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white font-medium">
            {{ $isEdit ? 'Actualizar Servicio' : 'Crear Servicio' }}
    </button>
    <a href="#"
        class="px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700">Cancelar</a>
</div>