<nav class="fixed top-0 w-full z-50 bg-background-dark/80 backdrop-blur-md border-b border-border-dark px-6 md:px-12 py-4">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <div class="text-primary">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 48 48">
                    <path d="M4 4H17.3334V17.3334H30.6666V30.6666H44V44H4V4Z"></path>
                </svg>
            </div>
            <span class="text-2xl font-bold tracking-tighter">XOKOL</span>
        </a>
        <div class="hidden md:flex items-center gap-10">
            <a class="text-sm font-medium hover:text-primary transition-colors" href="{{ route('home') }}">Inicio</a>
            <a href="{{ route('home') }}#contacto"
                class="bg-primary text-background-dark px-6 py-2.5 rounded-lg text-sm font-bold tracking-wide hover:opacity-90 transition-all">Contáctanos</a>
        </div>
        <button class="md:hidden text-primary">
            <span class="material-symbols-outlined">menu</span>
        </button>
    </div>
</nav>