<x-layouts.app>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Contactos</h1>
        <p class="mt-1 text-gray-600 dark:text-gray-400">Consultas comerciales y propuestas laborales recibidas desde el sitio.</p>
    </div>

    <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-900/50"><tr><th class="p-3 text-left">Contacto</th><th class="p-3 text-left">Motivo</th><th class="p-3 text-left">Servicios</th><th class="p-3 text-left">Estado</th><th class="p-3 text-left">Recibido</th><th class="p-3 text-right">Acciones</th></tr></thead>
            <tbody>
                @forelse ($contacts as $contact)
                    <tr class="border-t border-gray-200 dark:border-gray-700">
                        <td class="p-3"><p class="font-medium">{{ $contact->name }}</p><p class="text-xs text-gray-500">{{ $contact->email }}</p></td>
                        <td class="p-3">{{ str_replace('_', ' ', ucfirst($contact->inquiry_type)) }}</td>
                        <td class="p-3"><div class="flex flex-wrap gap-1">@forelse ($contact->services as $service)<span class="rounded bg-gray-100 px-2 py-1 text-xs dark:bg-gray-700">{{ $service->name }}</span>@empty <span class="text-gray-500">—</span>@endforelse</div></td>
                        <td class="p-3"><span class="rounded px-2 py-1 text-xs {{ $contact->status === 'nuevo' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200' }}">{{ ucfirst($contact->status) }}</span></td>
                        <td class="p-3 text-gray-500">{{ $contact->created_at->format('d/m/Y H:i') }}</td>
                        <td class="p-3 text-right"><a href="{{ route('admin.contacts.show', $contact) }}" class="rounded-md border border-gray-300 px-3 py-1 dark:border-gray-700">Ver mensaje</a></td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="p-6 text-center text-gray-500">Todavía no hay contactos recibidos.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.app>
