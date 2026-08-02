<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Etijah Coaching</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'DM Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 text-gray-900 antialiased">

    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside class="w-60 bg-slate-900 text-slate-300 flex flex-col shrink-0">
            <div class="px-6 py-6 border-b border-slate-800">
                <span class="text-white font-semibold text-lg">Etijah Admin</span>
            </div>
            <nav class="flex-1 px-3 py-6 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-brand-700 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.orders') }}" class="block px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.orders') ? 'bg-brand-700 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                    Orders
                </a>
                <a href="{{ route('admin.products') }}" class="block px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.products') ? 'bg-brand-700 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                    Products
                </a>
            </nav>
            <div class="px-3 py-4 border-t border-slate-800">
                <div class="px-3 pb-3 text-xs text-slate-500 truncate">{{ auth()->user()->email }}</div>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2.5 rounded-lg text-sm font-medium text-slate-300 hover:bg-slate-800 hover:text-white transition-colors">
                        Log out
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main --}}
        <div class="flex-1 flex flex-col min-w-0">
            <header class="bg-white border-b border-slate-200 px-8 py-5">
                <h1 class="font-semibold text-xl text-slate-900">@yield('title', 'Dashboard')</h1>
            </header>
            <main class="flex-1 px-8 py-8">
                @if (session('status'))
                    <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm px-4 py-3 rounded-lg">
                        {{ session('status') }}
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Dependency-free confirm: window.confirm() is unreliable in some
        // browsers/extensions/webviews (silently blocked or auto-cancelled),
        // which makes destructive buttons look broken. This arms the button
        // on first click and only lets the form submit on a second click
        // within a few seconds.
        document.addEventListener('click', function (e) {
            var btn = e.target.closest('[data-confirm]');
            if (!btn) return;

            if (btn.dataset.armed === 'true') {
                return;
            }

            e.preventDefault();
            e.stopPropagation();

            var original = btn.textContent;
            btn.dataset.armed = 'true';
            btn.textContent = btn.dataset.confirmLabel || 'Click to confirm';
            btn.classList.add('bg-red-600', 'text-white', 'border-red-600');

            setTimeout(function () {
                btn.dataset.armed = 'false';
                btn.textContent = original;
                btn.classList.remove('bg-red-600', 'text-white', 'border-red-600');
            }, 3000);
        });
    </script>

</body>
</html>
