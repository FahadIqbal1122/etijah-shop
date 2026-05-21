<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Etijah Coaching — Your Growth Hub')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        .font-display { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-slate-50 text-gray-900 flex flex-col min-h-screen antialiased">

    {{-- Header --}}
    <header class="bg-white/90 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="/">
                <img src="{{ asset('images/logo.png') }}" alt="Etijah Logo" class="h-9 max-h-9 w-auto">
            </a>
            <nav class="flex items-center gap-8">
                <a href="/shop" class="text-sm font-medium text-slate-600 hover:text-brand-600 transition-colors duration-200">Shop</a>
                <a href="/shop" class="text-sm font-semibold bg-brand-600 hover:bg-brand-700 text-white px-5 py-2 rounded-full transition-all duration-200 shadow-sm">
                    Browse Products
                </a>
            </nav>
        </div>
    </header>

    {{-- Page Content --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-slate-900 text-white mt-auto">
        <div class="max-w-6xl mx-auto px-6 py-12">
            <div class="flex flex-col md:flex-row items-center md:items-start justify-between gap-8">

                <div class="flex flex-col items-center md:items-start gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Etijah Logo" class="h-8 w-auto brightness-0 invert opacity-80">
                    <p class="text-slate-400 text-sm max-w-xs text-center md:text-left leading-relaxed">
                        Empowering individuals and organizations through expert coaching and transformative tools.
                    </p>
                </div>

                <div class="flex flex-col items-center md:items-end gap-3">
                    <div class="flex items-center gap-6 text-sm">
                        <a href="/terms" class="text-slate-400 hover:text-white transition-colors duration-200">Terms & Conditions</a>
                        <span class="text-slate-700">·</span>
                        <a href="/privacy" class="text-slate-400 hover:text-white transition-colors duration-200">Privacy Policy</a>
                    </div>
                    <p class="text-slate-600 text-xs">© {{ date('Y') }} Etijah Coaching & Consulting. All rights reserved.</p>
                </div>

            </div>
        </div>
    </footer>

</body>
</html>
