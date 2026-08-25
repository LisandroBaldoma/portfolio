<x-layouts.public :title="'IKIGAI | Sobre mí'">
    <section class="min-h-screen py-36 px-6 md:px-12 bg-card-dark border-y border-border-dark">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20 items-start">
            <div class="lg:col-span-5 lg:sticky lg:top-28">
                <span class="text-primary font-bold tracking-[0.2em] text-xs uppercase mb-4 block">Sobre mí</span>
                <h1 class="text-5xl md:text-6xl font-bold tracking-tighter leading-none mb-7">Código con<br><span class="text-primary italic">propósito.</span></h1>
                <p class="text-slate-400 text-lg leading-relaxed mb-8 max-w-xl">Soy Lisandro Baldoma, Full Stack Developer. Convierto procesos complejos en productos digitales claros, escalables y preparados para el crecimiento.</p>
                <div class="flex flex-wrap gap-3 mb-10">
                    <span class="inline-flex items-center gap-2 rounded-full border border-border-dark bg-background-dark px-4 py-2 text-sm text-slate-300"><span class="material-symbols-outlined text-primary text-lg">location_on</span> Rosario, Argentina</span>
                    <span class="inline-flex items-center gap-2 rounded-full border border-border-dark bg-background-dark px-4 py-2 text-sm text-slate-300"><span class="material-symbols-outlined text-primary text-lg">calendar_month</span> +3 años de experiencia</span>
                </div>
                <a href="{{ asset('documents/Lisandro-Baldoma-CV.pdf') }}" download class="inline-flex items-center gap-2 bg-primary text-background-dark px-7 py-4 rounded-lg font-bold hover:opacity-90 transition-all group">Descargar CV <span class="material-symbols-outlined transition-transform group-hover:translate-y-1">download</span></a>
            </div>

            <div class="lg:col-span-7 space-y-6">
                <article class="rounded-2xl border border-border-dark bg-background-dark p-7 md:p-9">
                    <div class="flex items-center gap-3 mb-7"><span class="material-symbols-outlined text-primary text-3xl">terminal</span><h2 class="text-2xl font-bold">Stack y capacidades</h2></div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-7">
                        <div><p class="text-xs uppercase tracking-[0.16em] text-primary font-bold mb-3">Backend</p><p class="text-slate-300 leading-relaxed">PHP · Laravel · Node.js · Express · APIs REST · MVC</p></div>
                        <div><p class="text-xs uppercase tracking-[0.16em] text-primary font-bold mb-3">Frontend</p><p class="text-slate-300 leading-relaxed">Vue.js · React · JavaScript · TypeScript</p></div>
                        <div><p class="text-xs uppercase tracking-[0.16em] text-primary font-bold mb-3">Datos e infraestructura</p><p class="text-slate-300 leading-relaxed">MySQL · SQL · CI/CD · SSH · Cloudflare</p></div>
                        <div><p class="text-xs uppercase tracking-[0.16em] text-primary font-bold mb-3">Flujo de trabajo</p><p class="text-slate-300 leading-relaxed">Git · GitHub · Bitbucket · IA aplicada al desarrollo</p></div>
                    </div>
                </article>

                <article class="rounded-2xl border border-border-dark bg-background-dark p-7 md:p-9">
                    <div class="flex items-start justify-between gap-5 mb-7"><div><span class="text-primary text-xs font-bold uppercase tracking-[0.16em]">Experiencia independiente</span><h2 class="text-2xl font-bold mt-2">Experiencia freelancer</h2></div><span class="material-symbols-outlined text-primary text-3xl">work</span></div>
                    <p class="text-slate-400 leading-relaxed mb-8">Desarrollo de productos digitales de punta a punta: descubrimiento técnico, arquitectura, implementación y puesta en producción.</p>
                    <div class="relative border-l border-border-dark ml-2 space-y-9">
                        @forelse ($projects as $project)
                            <div class="relative pl-7">
                                <span class="absolute -left-[5px] top-1.5 h-2.5 w-2.5 rounded-full bg-primary ring-4 ring-background-dark"></span>
                                <div class="flex flex-col sm:flex-row sm:items-baseline sm:justify-between gap-1 mb-2">
                                    <div><h3 class="font-bold text-lg">{{ $project->title }}</h3><p class="mt-1 text-sm text-primary">Full Stack Developer · Proyecto freelance</p></div>
                                    <span class="text-sm text-primary font-medium">{{ $project->published_at?->format('Y') }}</span>
                                </div>
                                <p class="text-slate-400 leading-relaxed">{{ $project->description }}</p>
                                <div class="mt-4 flex flex-wrap gap-2">
                                    @foreach (collect(explode(',', $project->technologies ?? ''))->filter() as $technology)
                                        <span class="rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary">{{ trim($technology) }}</span>
                                    @endforeach
                                    @if (blank($project->technologies))
                                        @foreach ($project->services as $service)
                                            <span class="rounded-full bg-slate-800 px-3 py-1 text-xs font-medium text-slate-300">{{ $service->name }}</span>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="mt-4 flex flex-wrap gap-4 text-sm font-bold">
                                    <a href="{{ route('projects.show', $project) }}" class="inline-flex items-center gap-1 hover:text-primary transition-colors">Ver caso <span class="material-symbols-outlined text-base">arrow_forward</span></a>
                                    @if ($project->production_url)
                                        <a href="{{ $project->production_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 text-primary hover:text-white transition-colors">Ver producción <span class="material-symbols-outlined text-base">open_in_new</span></a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="pl-7 text-slate-400">Los proyectos publicados aparecerán aquí automáticamente.</p>
                        @endforelse
                    </div>
                </article>

                <details class="group rounded-2xl border border-border-dark bg-background-dark">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-5 p-7 md:p-9">
                        <div><span class="text-primary text-xs font-bold uppercase tracking-[0.16em]">Trayectoria profesional</span><h2 class="mt-2 text-2xl font-bold">Experiencia laboral</h2><p class="mt-2 text-sm text-slate-400">Desplegá este bloque para conocer mi recorrido.</p></div>
                        <span class="material-symbols-outlined text-primary transition-transform group-open:rotate-45">add</span>
                    </summary>
                    <div class="border-t border-border-dark px-7 pb-8 pt-7 md:px-9">
                        <div class="relative border-l border-border-dark ml-2 space-y-8">
                            <div class="relative pl-7"><span class="absolute -left-[5px] top-1.5 h-2.5 w-2.5 rounded-full bg-primary ring-4 ring-background-dark"></span><div class="flex flex-col sm:flex-row sm:items-baseline sm:justify-between gap-1 mb-2"><h3 class="font-bold text-lg">Full Stack Developer · Jubbler Technologies</h3><span class="text-sm text-primary font-medium">2023 — 2026</span></div><p class="text-slate-400 leading-relaxed">APIs REST, automatización en Laravel, optimización SQL y despliegues con CI/CD, SSH y Cloudflare.</p></div>
                            <div class="relative pl-7"><span class="absolute -left-[5px] top-1.5 h-2.5 w-2.5 rounded-full bg-slate-600 ring-4 ring-background-dark"></span><div class="flex flex-col sm:flex-row sm:items-baseline sm:justify-between gap-1 mb-2"><h3 class="font-bold text-lg">Gestión Comercial y Operaciones · LR Soluciones Integrales</h3><span class="text-sm text-slate-500 font-medium">2013 — 2023</span></div><p class="text-slate-400 leading-relaxed">Experiencia de negocio que hoy aplico para diseñar soluciones prácticas, eficientes y orientadas a resultados.</p></div>
                        </div>
                    </div>
                </details>

                <div class="rounded-2xl border border-primary/25 bg-primary/5 p-7 md:p-8 flex flex-col sm:flex-row sm:items-center gap-5 justify-between"><div><p class="text-primary text-sm font-bold uppercase tracking-[0.16em] mb-2">Enfoque</p><p class="text-xl font-semibold">Del problema de negocio a una solución digital completa.</p></div><a href="{{ route('home') }}#contacto" class="shrink-0 inline-flex items-center gap-2 font-bold hover:text-primary transition-colors">Hablemos <span class="material-symbols-outlined">arrow_forward</span></a></div>
            </div>
        </div>
    </section>
</x-layouts.public>
