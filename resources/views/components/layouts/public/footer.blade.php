<footer class="py-12 px-6 md:px-12 bg-background-dark border-t border-border-dark">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-8">
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <div class="text-primary">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 48 48">
                    <path d="M4 4H17.3334V17.3334H30.6666V30.6666H44V44H4V4Z"></path>
                </svg>
            </div>
            <span class="text-xl font-bold tracking-tighter">XOKOL</span>
        </a>
        <p class="text-slate-500 text-sm">&copy; {{ now()->year }} XOKOL Studio. Todos los derechos reservados.</p>
        <div class="flex gap-6">
            <a class="text-slate-400 hover:text-primary transition-colors" href="#" aria-label="Compartir"><span
                    class="material-symbols-outlined">share</span></a>
            <a class="text-slate-400 hover:text-primary transition-colors" href="#" aria-label="Sitio"><span
                    class="material-symbols-outlined">language</span></a>
        </div>
    </div>
</footer>
