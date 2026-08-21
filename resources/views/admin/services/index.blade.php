<x-layouts.app>
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Servicios</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Administra los servicios que aparecen en el home.</p>
        </div>
        <a href="{{ route('admin.services.create') }}" class="px-4 py-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white font-medium">Nuevo Servicio</a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-900/50">
                <tr>
                    <th class="text-left p-3">Nombre</th>
                    <th class="text-left p-3">Slug</th>
                    <th class="text-left p-3">Ícono</th>
                    <th class="text-left p-3">Orden</th>
                    <th class="text-left p-3">Estado</th>
                    <th class="text-right p-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                    <tr class="border-t border-gray-200 dark:border-gray-700">
                        <td class="p-3">
                            <p class="font-medium">{{ $service->name }}</p>
                            <p class="text-xs text-gray-500 line-clamp-1">{{ $service->description }}</p>
                        </td>
                        <td class="p-3">{{ $service->slug }}</td>
                        <td class="p-3">{{ $service->icon }}</td>
                        <td class="p-3">{{ $service->sort_order }}</td>
                        <td class="p-3">
                            <span
                                class="text-xs px-2 py-1 rounded {{ $service->is_active ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300' }}">
                                {{ $service->is_active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="p-3">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.services.edit', $service) }}"
                                    class="px-3 py-1 rounded-md border border-gray-300 dark:border-gray-700">Editar</a>
                                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" onsubmit="return confirm('Eliminar servicio?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 rounded-md bg-red-600 hover:bg-red-700 text-white">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-6 text-center text-gray-500">No hay servicios registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.app>

