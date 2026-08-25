<div class="bg-card-dark p-8 md:p-12 rounded-3xl border border-border-dark">
    @php
        $services = $services ?? \App\Models\Service::query()->where('is_active', true)->orderBy('sort_order')->get();
    @endphp

    @if (session('contact_success'))
        <div class="mb-6 rounded-lg border border-primary/30 bg-primary/10 p-4 text-sm text-slate-100" role="status">
            {{ session('contact_success') }}
        </div>
    @endif

    <form class="space-y-8" method="POST" action="{{ route('contact.send') }}">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-2">
                <label for="contact-name" class="text-xs font-bold uppercase tracking-widest text-slate-500">Nombre y apellido</label>
                <input id="contact-name" name="name" value="{{ old('name') }}" required autocomplete="name"
                    class="w-full bg-transparent border-0 border-b border-slate-700 focus:border-primary focus:ring-0 py-2 placeholder:text-slate-600 transition-colors"
                    placeholder="Ej.: Martina González" type="text" />
                @error('name') <p class="text-sm text-red-400">{{ $message }}</p> @enderror
            </div>
            <div class="space-y-2">
                <label for="contact-phone" class="text-xs font-bold uppercase tracking-widest text-slate-500">Teléfono <span class="normal-case font-normal">(opcional)</span></label>
                <input id="contact-phone" name="phone" value="{{ old('phone') }}" autocomplete="tel"
                    class="w-full bg-transparent border-0 border-b border-slate-700 focus:border-primary focus:ring-0 py-2 placeholder:text-slate-600 transition-colors"
                    placeholder="+54 9 341 123 4567" type="tel" />
                @error('phone') <p class="text-sm text-red-400">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-2">
                <label for="contact-email" class="text-xs font-bold uppercase tracking-widest text-slate-500">Correo electrónico</label>
                <input id="contact-email" name="email" value="{{ old('email') }}" required autocomplete="email"
                    class="w-full bg-transparent border-0 border-b border-slate-700 focus:border-primary focus:ring-0 py-2 placeholder:text-slate-600 transition-colors"
                    placeholder="nombre@empresa.com" type="email" />
                @error('email') <p class="text-sm text-red-400">{{ $message }}</p> @enderror
            </div>
            <div class="space-y-2">
                <label for="contact-company" class="text-xs font-bold uppercase tracking-widest text-slate-500">Empresa u organización <span class="normal-case font-normal">(opcional)</span></label>
                <input id="contact-company" name="company" value="{{ old('company') }}" autocomplete="organization"
                    class="w-full bg-transparent border-0 border-b border-slate-700 focus:border-primary focus:ring-0 py-2 placeholder:text-slate-600 transition-colors"
                    placeholder="Ej.: Estudio Norte" type="text" />
                @error('company') <p class="text-sm text-red-400">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="space-y-2">
            <label for="contact-inquiry-type" class="text-xs font-bold uppercase tracking-widest text-slate-500">Motivo de contacto</label>
            <select id="contact-inquiry-type" name="inquiry_type" required class="w-full bg-transparent border-0 border-b border-slate-700 focus:border-primary focus:ring-0 py-2 text-slate-200 transition-colors">
                <option value="" class="bg-card-dark">Seleccioná una opción</option>
                <option value="servicios" @selected(old('inquiry_type') === 'servicios') class="bg-card-dark">Quiero contratar servicios</option>
                <option value="propuesta_laboral" @selected(old('inquiry_type') === 'propuesta_laboral') class="bg-card-dark">Tengo una propuesta laboral</option>
                <option value="otro" @selected(old('inquiry_type') === 'otro') class="bg-card-dark">Otro motivo</option>
            </select>
            @error('inquiry_type') <p class="text-sm text-red-400">{{ $message }}</p> @enderror
        </div>

        <fieldset class="space-y-4">
            <legend class="text-xs font-bold uppercase tracking-widest text-slate-500">Servicios de interés <span class="normal-case font-normal">(opcional)</span></legend>
            <div class="flex flex-wrap gap-2">
                @foreach ($services as $service)
                    <label class="cursor-pointer">
                        <input class="hidden peer" type="checkbox" name="services[]" value="{{ $service->id }}" @checked(in_array($service->id, old('services', []))) />
                        <span class="px-4 py-2 rounded-lg border border-slate-700 text-sm peer-checked:bg-primary peer-checked:text-background-dark peer-checked:border-primary transition-all inline-block">{{ $service->name }}</span>
                    </label>
                @endforeach
            </div>
            @error('services.*') <p class="text-sm text-red-400">{{ $message }}</p> @enderror
        </fieldset>

        <div class="space-y-2">
            <label for="contact-message" class="text-xs font-bold uppercase tracking-widest text-slate-500">Contame en qué puedo ayudarte</label>
            <textarea id="contact-message" name="message" rows="6" required minlength="10"
                class="w-full bg-transparent border-0 border-b border-slate-700 focus:border-primary focus:ring-0 py-2 placeholder:text-slate-600 transition-colors"
                placeholder="Contame brevemente sobre tu proyecto, necesidad o propuesta.">{{ old('message') }}</textarea>
            @error('message') <p class="text-sm text-red-400">{{ $message }}</p> @enderror
        </div>

        <button class="w-full bg-primary text-background-dark py-4 rounded-xl font-bold text-lg hover:opacity-90 transition-all">Enviar consulta</button>
    </form>
</div>
