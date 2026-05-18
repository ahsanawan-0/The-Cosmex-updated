<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Cosmex Pvt Ltd</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>
<body class="min-h-screen bg-bg-light font-sans text-text-primary">
    <div class="flex min-h-screen items-center justify-center px-5 py-10">
        <div class="w-full max-w-md rounded-[24px] bg-white p-6 shadow-card sm:p-8">
            <div class="mb-8 text-center">
                <p class="font-heading text-4xl font-bold tracking-tight text-primary">Cosmex</p>
                <p class="mt-1 text-sm font-medium text-text-secondary">Admin Portal</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-600 shadow-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="mb-2 block text-sm font-semibold text-text-primary">Email Address</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="min-h-12 w-full rounded-2xl border border-border bg-bg-light px-4 text-text-primary outline-none transition focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/10"
                        placeholder="admin@cosmexpvtltd.com"
                    >
                </div>

                <div>
                    <label for="password" class="mb-2 block text-sm font-semibold text-text-primary">Password</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        class="min-h-12 w-full rounded-2xl border border-border bg-bg-light px-4 text-text-primary outline-none transition focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/10"
                        placeholder="Password"
                    >
                </div>

                <button type="submit" class="btn-primary mt-2 w-full">
                    Secure Login
                </button>
            </form>
        </div>
    </div>
</body>
</html>
