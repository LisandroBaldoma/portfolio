<x-layouts.app>
    @php $isEdit = isset($project); @endphp

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $isEdit ? 'Editar Proyecto' : 'Nuevo Proyecto' }}</h1>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
        <form method="POST" action="{{ $isEdit ? route('admin.projects.update', $project) : route('admin.projects.store') }}" enctype="multipart/form-data">
            @csrf
            @if($isEdit)
                @method('PATCH')
            @endif
            @include('admin.projects._form', ['services' => $services, 'project' => $project ?? null])
        </form>
    </div>
</x-layouts.app>