<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — Etijah Coaching</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'DM Sans', sans-serif; }</style>
</head>
<body class="bg-slate-900 text-gray-900 antialiased min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-sm">
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="Etijah Logo" class="h-9 mx-auto mb-4 brightness-0 invert opacity-90">
            <p class="text-slate-400 text-sm">Admin sign in</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8">
            @if ($errors->any())
                <div class="mb-5 bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Password</label>
                    <input type="password" name="password" required
                        class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                </div>
                <button type="submit" class="w-full bg-brand-700 hover:bg-brand-800 text-white font-semibold py-2.5 rounded-lg transition-colors duration-200">
                    Sign In
                </button>
            </form>
        </div>
    </div>

</body>
</html>
