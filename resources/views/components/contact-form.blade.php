<div class="bg-card-dark p-8 md:p-12 rounded-3xl border border-border-dark">
    @php
        $services = $services ?? \App\Models\Service::orderBy('name')->get();
    @endphp

    @if(session('contact_success'))
        <div class="mb-4 p-4 rounded-lg bg-green-700 text-white">{{ session('contact_success') }}</div>
    @endif

    <form class="space-y-8" method="POST" action="{{ route('contact.send') }}">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-2">
                <label class="text-xs font-bold uppercase tracking-widest text-slate-500">Nombre Completo</label>
                <input
                    name="name"
                    value="{{ old('name') }}"
                    class="w-full bg-transparent border-0 border-b border-slate-700 focus:border-primary focus:ring-0 py-2 placeholder:text-slate-700 transition-colors"
                    placeholder="John Doe" type="text" />
                @error('name') <div class="text-sm text-red-400 mt-1">{{ $message }}</div> @enderror
            </div>
            <div class="space-y-2">
                <label class="text-xs font-bold uppercase tracking-widest text-slate-500">Teléfono</label>
                <input
                    name="phone"
                    value="{{ old('phone') }}"
                    class="w-full bg-transparent border-0 border-b border-slate-700 focus:border-primary focus:ring-0 py-2 placeholder:text-slate-700 transition-colors"
                    placeholder="+1 (555) 000-0000" type="tel" />
                @error('phone') <div class="text-sm text-red-400 mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="space-y-2">
            <label class="text-xs font-bold uppercase tracking-widest text-slate-500">Compañía / Empresa</label>
            <input
                name="company"
                value="{{ old('company') }}"
                class="w-full bg-transparent border-0 border-b border-slate-700 focus:border-primary focus:ring-0 py-2 placeholder:text-slate-700 transition-colors"
                placeholder="Awesome Inc." type="text" />
            @error('company') <div class="text-sm text-red-400 mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="space-y-2">
            <label class="text-xs font-bold uppercase tracking-widest text-slate-500">Correo Electrónico</label>
            <input
                name="email"
                value="{{ old('email') }}"
                class="w-full bg-transparent border-0 border-b border-slate-700 focus:border-primary focus:ring-0 py-2 placeholder:text-slate-700 transition-colors"
                placeholder="correo@dominio.com" type="email" />
            @error('email') <div class="text-sm text-red-400 mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="space-y-4">
            <label class="text-xs font-bold uppercase tracking-widest text-slate-500">Servicios Requeridos</label>
            <div class="flex flex-wrap gap-2">
                @foreach($services as $service)
                    <label class="cursor-pointer">
                        <input class="hidden peer" type="checkbox" name="services[]" value="{{ $service->id }}" {{ (is_array(old('services')) && in_array($service->id, old('services'))) ? 'checked' : '' }} />
                        <span
                            class="px-4 py-2 rounded-lg border border-slate-700 text-sm peer-checked:bg-primary peer-checked:text-background-dark peer-checked:border-primary transition-all inline-block">{{ $service->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="space-y-2">
            <label class="text-xs font-bold uppercase tracking-widest text-slate-500">Mensaje</label>
            <textarea name="message" rows="6" class="w-full bg-transparent border-0 border-b border-slate-700 focus:border-primary focus:ring-0 py-2 placeholder:text-slate-700 transition-colors">{{ old('message') }}</textarea>
            @error('message') <div class="text-sm text-red-400 mt-1">{{ $message }}</div> @enderror
        </div>

        <button class="w-full bg-primary text-background-dark py-4 rounded-xl font-bold text-lg hover:opacity-90 transition-all">
            Enviar Propuesta
        </button>
    </form>
</div>