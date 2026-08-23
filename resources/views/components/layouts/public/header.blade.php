<nav class="fixed top-0 w-full z-50 bg-background-dark/80 backdrop-blur-md border-b border-border-dark px-6 md:px-12 py-4">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <div class="text-primary">
                <svg class="w-8 h-8 text-primary" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Circuito base de red -->
                    <circle cx="24" cy="24" r="18" stroke="#2A384D" stroke-width="1.5" stroke-dasharray="3 3"/>
                    
                    <!-- Trazo Enso Digital (Amarillo Acento / Primary) -->
                    <path d="M 12 18 A 14 14 0 1 1 10 28" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                    
                    <!-- Nodos de IA e interconexiones -->
                    <path d="M 12 18 L 8 14 H 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    <circle cx="4" cy="14" r="2" fill="currentColor"/>
                    
                    <path d="M 32 34 L 38 38 H 44" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    <circle cx="44" cy="38" r="2" fill="currentColor"/>
                    
                    <!-- Núcleo de Red Interna -->
                    <line x1="20" y1="20" x2="28" y2="18" stroke="#C2C9D6" stroke-width="1.2"/>
                    <line x1="28" y1="18" x2="29" y2="28" stroke="#C2C9D6" stroke-width="1.2"/>
                    <line x1="29" y1="28" x2="19" y2="27" stroke="currentColor" stroke-width="1.2"/>
                    <line x1="19" y1="27" x2="20" y2="20" stroke="#C2C9D6" stroke-width="1.2"/>
                    
                    <circle cx="20" cy="20" r="1.5" fill="#FFFFFF"/>
                    <circle cx="28" cy="18" r="2" fill="currentColor"/>
                    <circle cx="29" cy="28" r="1.5" fill="#FFFFFF"/>
                    <circle cx="19" cy="27" r="2" fill="currentColor"/>
                </svg>
            </div>
            <span class="text-2xl font-bold tracking-tighter">IKIGAI</span>
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

