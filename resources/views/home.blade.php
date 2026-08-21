<x-layouts.public :title="'XOKOL | Inicio'">

    @php
        // Projects are provided by HomeController
    @endphp
    @endphp

    <section class="relative h-screen w-full flex items-center overflow-hidden pt-16">
        <div class="absolute inset-0 z-0">
            <div class="w-full h-full bg-cover bg-center transition-all duration-700 opacity-40"
                style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuArHKmqyDxpv94gnoyQrPyfFJTwjFoBdUSo4r-Yky1LenCChsPo8ynrfSsFDVULOgt1KpbOYEwmftcSqnAFgN2gKpXgmZ8T33yEiFyoF8zyRf2ExK6mienbpNpKQlTVdB8h4iyvrMxiTd7DnMA4zMoyqxGVGRE3ZHKtuOrDZJrsbZniqVvc0nFBiojAOyd-2gTnowjfL1CGLv2pmlb8Rh2jFmoR54TThOrUa-2j6R13q9SGLEPii1fpfxIdqhznbwufmBBgrx_61r7R')">
            </div>
            <div class="absolute inset-0 bg-gradient-to-r from-background-dark via-background-dark/60 to-transparent"></div>
        </div>
        <div class="relative z-10 px-6 md:px-24 max-w-5xl">
            <span class="text-primary font-bold tracking-[0.2em] text-xs uppercase mb-4 block">Creative Excellence</span>
            <h1 class="text-6xl md:text-8xl font-bold leading-none mb-8 tracking-tighter">Creatividad <br> <span
                    class="text-primary italic">Sin L&iacute;mites</span></h1>
            <p class="text-slate-400 text-lg md:text-xl max-w-xl mb-10 font-light leading-relaxed">Elevamos tu marca al
                siguiente nivel con estrategias digitales disruptivas y diseño de vanguardia.</p>
            <div class="flex flex-wrap gap-4">
                <a href="#proyectos"
                    class="bg-primary text-background-dark px-8 py-4 rounded-lg font-bold flex items-center gap-2 group transition-all">
                    Ver Proyectos <span class="material-symbols-outlined transition-transform group-hover:translate-x-1">arrow_forward</span>
                </a>
                <button class="border border-slate-700 hover:border-primary px-8 py-4 rounded-lg font-bold transition-all">Nuestro
                    Estudio</button>
            </div>
        </div>
    </section>

    <section class="py-24 px-6 md:px-12 bg-background-dark border-t border-border-dark" id="servicios">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
                <div>
                    <h2 class="text-4xl md:text-5xl font-bold mb-4 tracking-tight">Nuestros <span class="text-primary">Servicios</span>
                    </h2>
                    <p class="text-slate-400 max-w-md">Soluciones visuales y estratégicas para negocios que buscan destacar en la era
                        digital.</p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse ($services as $service)
                    <article class="bg-card-dark border border-border-dark p-8 rounded-xl hover:border-primary/50 transition-all group">
                        <div class="text-primary mb-6">
                            <span class="material-symbols-outlined text-4xl">{{ $service->icon }}</span>
                        </div>
                        <h3 class="text-xl font-bold mb-3">{{ $service->name }}</h3>
                        <p class="text-slate-400 text-sm leading-relaxed mb-6">{{ $service->description ?? 'Servicio administrable desde CMS.' }}</p>
                        <span class="text-xs font-bold text-slate-500 group-hover:text-primary transition-colors">{{ $service->projects_count ?? 0 }} Proyectos</span>
                    </article>
                @empty
                    <div class="col-span-1 lg:col-span-4 text-center text-slate-400">No hay servicios disponibles.</div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="py-24 px-6 md:px-12 bg-background-dark" id="proyectos">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row items-center justify-between mb-12 gap-8">
                <h2 class="text-4xl font-bold tracking-tight">Proyectos <span class="text-primary">Destacados</span></h2>
                <div class="flex flex-wrap gap-3">
                    <button class="px-6 py-2 rounded-full bg-primary text-background-dark font-bold text-sm">Todos</button>
                    <button class="px-6 py-2 rounded-full bg-card-dark border border-border-dark hover:border-primary/50 text-slate-300 font-bold text-sm transition-all">Branding</button>
                    <button class="px-6 py-2 rounded-full bg-card-dark border border-border-dark hover:border-primary/50 text-slate-300 font-bold text-sm transition-all">Digital</button>
                    <button class="px-6 py-2 rounded-full bg-card-dark border border-border-dark hover:border-primary/50 text-slate-300 font-bold text-sm transition-all">Motion</button>
                </div>
            </div>
            <div class="masonry-grid">
                @foreach ($projects as $project)
                    <a href="#"
                        class="grid-size-{{ $project->grid_image_size }} group relative overflow-hidden rounded-xl bg-card-dark border border-border-dark">
                        <img alt="{{ $project->title }}"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 opacity-70"
                            src="{{ $project->grid_image_path }}" />
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-background-dark via-background-dark/20 to-transparent opacity-60 group-hover:opacity-90 transition-opacity duration-500">
                        </div>
                        <div
                            class="absolute inset-0 p-8 flex flex-col justify-end translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                            <h3 class="text-2xl font-bold mb-4">{{ $project->title }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-24 px-6 md:px-12 bg-background-dark" id="contacto">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16">
            <div>
                <h2 class="text-5xl md:text-7xl font-bold mb-8 tracking-tighter">Hagamos algo <br><span class="text-primary italic">increíble</span>
                </h2>
                <p class="text-slate-400 text-lg mb-12 max-w-md">Cuéntanos sobre tu proyecto. Estamos listos para llevar tu marca al
                    siguiente nivel.</p>
            </div>
            <x-contact-form />
        </div>
    </section>

</x-layouts.public>