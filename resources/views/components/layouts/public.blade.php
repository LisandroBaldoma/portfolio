@props(['title' => 'XOKOL'])

<!DOCTYPE html>
<html class="dark" lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
        {{ $title }}
    </title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#D4FF00',
                        'background-light': '#f7f8f5',
                        'background-dark': '#050505',
                        'card-dark': '#121212',
                        'border-dark': '#1f1f1f',
                    },
                    fontFamily: {
                        display: ['Space Grotesk', 'sans-serif'],
                    },
                },
            },
        }
    </script>
    <style type="text/tailwindcss">
        @layer base {
            body {
                font-family: 'Space Grotesk', sans-serif;
                background-color: #050505;
            }
        }
        .masonry-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            grid-auto-rows: 160px;
            gap: 24px;
        }
        .grid-size-1 {
            grid-row: span 2;
        }
        .grid-size-2 {
            grid-row: span 3;
        }
        .grid-size-3 {
            grid-row: span 4;
        }
        @media (max-width: 768px) {
            .masonry-grid {
                grid-template-columns: 1fr;
                grid-auto-rows: auto;
            }
            .grid-size-1,
            .grid-size-2,
            .grid-size-3 {
                grid-row: span 1;
                aspect-ratio: 4/5;
            }
        }
    </style>
    @stack('styles')
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 selection:bg-primary selection:text-background-dark">

    <x-layouts.public.header />

    <main>
        {{ $slot }}
    </main>

    <x-layouts.public.footer />

    @stack('scripts')
</body>

</html>