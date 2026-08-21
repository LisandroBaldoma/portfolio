<x-layouts.public :title="'XOKOL | Proyecto'">

    <section class="relative h-screen w-full flex flex-col justify-end overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img alt="Project Hero" class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-1000"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCTVO4cJ9DON_clO_Kg_J5zMC03VuUIpJf0fE1_jipfnNyWb-KXENx6NF1zCJHhtUSnZEGSOEZO6aeQMvMZi4NIteUjTTegeUz7bPNleoB7EgzgjV9jpqa8bIwTphcUttnY8vvKdBZIowrX7wBQq0IS2feVg9FiRoe69GpanH55Qk-jm4cqI6fXtZwa9dZQ-s9w_6dpxauyfhdFinc2mDdRqvU7jFhGmaCc1srHskIdqpXSj48VIffrAm858LT5IjV5yfSxkcpmHZc3" />
            <div class="absolute inset-0 bg-gradient-to-t from-background-dark via-background-dark/40 to-transparent"></div>
        </div>
        <div class="relative z-10 max-w-7xl mx-auto px-6 pb-20 w-full">
            <div class="flex flex-wrap gap-3 mb-8">
                <span
                    class="px-4 py-1.5 rounded-full border border-primary/50 text-primary text-xs font-bold uppercase tracking-widest bg-primary/10">Identidad
                    de Marca</span>
                <span
                    class="px-4 py-1.5 rounded-full border border-white/20 text-white/70 text-xs font-bold uppercase tracking-widest bg-white/5">Sistemas
                    de Motion</span>
            </div>
            <h1 class="text-6xl md:text-8xl lg:text-[10rem] font-bold leading-[0.85] tracking-tighter uppercase mb-6">Neon<br><span
                    class="text-primary italic">Distorsi&oacute;n</span></h1>
            <p class="max-w-xl text-lg text-slate-300 font-light leading-relaxed">
                Una narrativa visual de alto impacto para una marca tecnol&oacute;gica que buscaba romper el ruido del mercado.
            </p>
        </div>
        <div class="absolute bottom-0 right-0 z-20 bg-primary px-8 py-6 hidden lg:flex items-center gap-12 rounded-tl-3xl">
            <div class="flex flex-col">
                <span class="text-[10px] uppercase font-bold text-black/60 tracking-widest">Vistas</span>
                <span class="text-2xl font-bold text-black tracking-tighter">14,208</span>
            </div>
            <div class="flex flex-col">
                <span class="text-[10px] uppercase font-bold text-black/60 tracking-widest">Likes</span>
                <span class="text-2xl font-bold text-black tracking-tighter">2,841</span>
            </div>
            <button class="group flex items-center gap-3 bg-black text-white px-6 py-3 rounded-xl hover:bg-neutral-900 transition-all">
                <span class="material-symbols-outlined text-primary">favorite</span>
                <span class="text-sm font-bold uppercase tracking-widest">Me gusta</span>
            </button>
        </div>
    </section>

    <section class="py-24 md:py-40 bg-background-dark">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-12 gap-12 items-start">
            <div class="md:col-span-4">
                <h3 class="text-xs font-bold text-primary uppercase tracking-[0.3em] mb-4">01. El Desaf&iacute;o</h3>
                <h2 class="text-4xl font-bold tracking-tight uppercase leading-none">Redefinir lo<br>subterr&aacute;neo.</h2>
            </div>
            <div class="md:col-span-8">
                <p class="text-xl md:text-2xl text-slate-300 font-light leading-relaxed">
                    El objetivo fue crear un lenguaje gr&aacute;fico premium y crudo al mismo tiempo: tipograf&iacute;a agresiva, alto
                    contraste y composiciones que transmiten energ&iacute;a en cada punto de contacto.
                </p>
            </div>
        </div>
    </section>

    <section class="w-full px-4 md:px-10">
        <div class="aspect-video w-full rounded-2xl overflow-hidden group">
            <img alt="Detalle del proyecto" class="w-full h-full object-cover scale-105 group-hover:scale-100 transition-transform duration-[2s]"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDzic8C7ixQcYaoo29RPB0Ue7DvebGV5BMfjDxjskv8NQweD1dPzHvOHRK5SugTI5l2wA59gE2YzYGLcfA6Kp_1U_LyUNakd2mXdQYwYKfYpjfKZmHJ4YwVxnv-4-1Z67RlRo6UWk_yeWsx35F1hzWUjmjL2pTeVflciSpTQhLDMjr0hLH-rmuzMFsD_0Q6dqPNFA1td4PTBs0MrGbv6ae4lKeFQ8N-1gfPIjPqRcu2JVZWLrn0lG_QEYWefIqpVAnJuSoVwJPF69zn" />
        </div>
    </section>

    <section class="py-24 border-t border-white/5 bg-background-dark/50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-end justify-between mb-16">
                <div>
                    <h3 class="text-xs font-bold text-primary uppercase tracking-[0.3em] mb-4">Sigue explorando</h3>
                    <h2 class="text-5xl font-bold tracking-tighter uppercase">M&aacute;s proyectos</h2>
                </div>
                <a class="group flex items-center gap-4 text-sm font-bold uppercase tracking-widest hover:text-primary transition-colors"
                    href="{{ route('home') }}#proyectos">Ver todos <span
                        class="material-symbols-outlined group-hover:translate-x-2 transition-transform">arrow_forward</span></a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                @foreach (['Omni-Channel UI', 'Data Flow Visuals'] as $related)
                    <article class="group cursor-pointer">
                        <div class="aspect-[16/10] rounded-2xl overflow-hidden mb-6 bg-card-dark border border-white/10">
                            <img alt="{{ $related }}"
                                class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-105 transition-all duration-700"
                                src="https://images.unsplash.com/photo-1545239351-1141bd82e8a6?auto=format&fit=crop&w=1200&q=80" />
                        </div>
                        <div class="flex justify-between items-start">
                            <h4 class="text-2xl font-bold uppercase tracking-tight mb-2">{{ $related }}</h4>
                            <span class="material-symbols-outlined text-primary opacity-0 group-hover:opacity-100 transition-opacity">north_east</span>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-24 px-6 md:px-12 bg-background-dark border-t border-white/5" id="contacto">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
            <div>
                <h2 class="text-5xl md:text-7xl font-bold mb-8 tracking-tighter">Hagamos algo <br><span
                        class="text-primary italic">incre&iacute;ble</span></h2>
                <p class="text-slate-400 text-lg mb-12 max-w-md">Cu&eacute;ntanos sobre tu proyecto. Estamos listos para llevar tu marca
                    al siguiente nivel.</p>
            </div>
            <x-contact-form />
        </div>
    </section>

</x-layouts.public>