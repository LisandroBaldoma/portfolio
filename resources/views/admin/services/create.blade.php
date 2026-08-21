<x-layouts.app>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Crear Servicio</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Agrega un nuevo servicio que aparecerá en la home.</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
        <form action="{{ route('admin.services.store') }}" method="POST">
            @csrf
            @include('admin.services._form')
        </form>
    </div>
</x-layouts.app>
