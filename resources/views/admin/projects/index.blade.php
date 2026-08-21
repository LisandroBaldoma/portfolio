<x-layouts.app>
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Proyectos</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Administra los proyectos del sitio.</p>
        </div>
        <a href="{{ route('admin.projects.create') }}"
            class="px-4 py-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white font-medium">Nuevo Proyecto</a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-900/50">
                <tr>
                    <th class="text-left p-3">Proyecto</th>
                    <th class="text-left p-3">Servicios</th>
                    <th class="text-left p-3">Estado</th>
                    <th class="text-right p-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projects as $project)
                    <tr class="border-t border-gray-200 dark:border-gray-700">
                        <td class="p-3">
                            <p class="font-medium">{{ $project->title }}</p>
                            <p class="text-xs text-gray-500">{{ \Illuminate\Support\Str::limit($project->description, 80) }}</p>
                        </td>
                        <td class="p-3">
                            <div class="flex flex-wrap gap-1">
                                @forelse($project->services as $svc)
                                    <span class="text-xs px-2 py-1 rounded bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">{{ $svc->name }}</span>
                                @empty
                                    <span class="text-xs text-gray-500">—</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="p-3">
                            <span
                                class="text-xs px-2 py-1 rounded {{ $project->is_active ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300' }}">
                                {{ $project->is_active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="p-3">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.projects.edit', $project) }}"
                                    class="px-3 py-1 rounded-md border border-gray-300 dark:border-gray-700">Editar</a>
                                <form
                                    method="POST"
                                    action="{{ route('admin.projects.destroy', $project) }}" onsubmit="return confirm('¿Eliminar proyecto?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1 rounded-md bg-red-600 hover:bg-red-700 text-white">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-6 text-center text-gray-500">No hay proyectos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.app>