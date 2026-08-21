<x-layouts.public :title="'XOKOL | Inicio'">

    @php
        $projects = [
            [
                'size' => '3',
                'title' => 'Neo-Glow Identity',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuC5vdOzTnNRzmfPzdCoyKzg1W9rzTm8kRzkxbq5BFAebev6_oDRO-6DlQqxQuhau9MdtH3tIvifHDjuDLTgiM2m4G7xsSM1R4XBrrCH2IC1WXRtuvxLOD3RNH8zkzh45ckTXL_wAs5Y6rnbFnX-7jXQHOVz9R6TptSPNOgmrNiZWst0eAvonXThEQHFZHCPfp852NeU-sfbqAZVvpwBfoP6itam4o1maFbHaozRY0scJD0bk7CbFKeymVQgkaSvxG6avDExRvwJAWg0',
            ],
            [
                'size' => '1',
                'title' => 'Tech Legacy',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCRnmskudL9AdnStX3CN3gmoEtZa-3fz2jwLz2wu1I4N6LbjVmKi---U7aeTfFlfn4Ulys4zXbkkRrLv7suzAnandazrYPGfsylxT1V9rb7IFzvurh2jLEl75jTEgn7788UaYbR_7E1THhfnGEFwomUcYv21rdOUzCjK-q34Go-fc9d_NlyWjbV_Lq_9pcXfKJnONuZX5sc1a_y_mDOm6ITZKSWG7r59OMhxCyt2kQDQ_zp5CGnYOC8E0WKsX_ZU2TVDn3lnNqn9lRI',
            ],
            [
                'size' => '2',
                'title' => 'Vibe Shift',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCHR7GDmTZJpq_bZCwb_SZToptgqm_1yT1zQG7duPOCDYH3f5idNqeAoBCQnYVTut4Y7i15vFdTva8i9jyaNHZNohrP4cyYKxis66a0ntyIQu4iaq73OSVhnL0Of7CcAOk8iPmhRU5SaZxZX46BveiunPnpU71L1JJAhb37LOCV5TFYeQf4Yw5p-7k4hku9OKKgkMON5wbYa60oo3WLeXDrilnr1R5Em7W-haKD4mRpTnqQSUsgXPFqNk8fImz1MEGjLT1w9nCzZHys',
            ],
            [
                'size' => '2',
                'title' => 'Luminal App',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuA1MZo6sCcIw06gfThgaLKwecvp4arfGY3Qf4dfJKfx_VD_g6jGz7B7PG3pUw88H9WIjEqcCK6zv0aGYI0oCv8aYivBmMOn5wCh0Yg0X1ozLGtvBO7ZzRZIucC0CJGloQjtNFPNCzs5DotbsSLPCV7RDYogNtW-IhHjke1bcg7nyt5qEavR9ZckLTzxTun2pzHbHVMQYJDRj9B65dqdb6faJsbtEQhgsxN2EGhVUplJDrDIa5KgVKz_IcT7jxIXZo2lEFBK31tDs_2M',
            ],
            [
                'size' => '3',
                'title' => 'Void Space',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuB_cqKKv6TNjl2lZzYmw-qMVS4cNvApnegzQOSLGbbzUA4IRhvKToGYvOOlEkIIF6EIv9piRghI0T0fBtL6gQ6WFoHGJMbtyUre6sQIROGGdhpY0Xn66X3Ll2A-NToAGxPca7AEq56jaDVGO7idrrqfqX1mtqMUe_gTbIX_JfInBBmV8OjZHkaTVB0YYfz6KqdcvxvzHEybTZdAZ8mqpqlODmuyoY3cOylyZbDtiZLIpocxgBLxFwVsINpt7G9gCznYQ7h-xIsEjTdA',
            ],
            [
                'size' => '1',
                'title' => 'Monolith Studio',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDRGewAh8EVDQ56-CNX7lENAkQUDyx6_BEGaydMU82UW1SxejwSppOjgb2IbcmmK7l5UnDPNEOzbJlkyMI4eIKE57Sg1iRKyrP-jHHWNm-1Ry7HK75ayrgOqvJWLR9hpWSwOVG7DrYeCcjT38uj1KU9Me1sFxfVS5XBLv4baFebq9J7ETVOw7snGV6WYENK0C2XONXlDsDXNS9fJ1KAA-cQtA_U8ubA7WS6yeG4o-WhGp7G7fCBVcHOMWuElSSHYoLQDdCJ-pNS1PRL',
            ],
        ];
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
                    <a href="{{ route('project') }}"
                        class="grid-size-{{ $project['size'] }} group relative overflow-hidden rounded-xl bg-card-dark border border-border-dark">
                        <img alt="{{ $project['title'] }}"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 opacity-70"
                            src="{{ $project['image'] }}" />
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-background-dark via-background-dark/20 to-transparent opacity-60 group-hover:opacity-90 transition-opacity duration-500">
                        </div>
                        <div
                            class="absolute inset-0 p-8 flex flex-col justify-end translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                            <h3 class="text-2xl font-bold mb-4">{{ $project['title'] }}</h3>
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