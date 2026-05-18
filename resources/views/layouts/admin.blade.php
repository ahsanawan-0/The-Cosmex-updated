<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') | Cosmex Pvt Ltd</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>
@php
    $pageTitle = trim($__env->yieldContent('page_title'));
    $pageTitle = $pageTitle !== '' ? $pageTitle : trim($__env->yieldContent('title', 'Dashboard'));
    $adminUser = auth()->user();
    $navLinkClasses = fn (bool $active) => 'group flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium transition '.($active ? 'bg-primary/10 text-primary' : 'text-zinc-600 hover:bg-zinc-50 hover:text-zinc-900');
    $iconClasses = fn (bool $active) => 'h-5 w-5 '.($active ? 'text-primary' : 'text-zinc-400 group-hover:text-zinc-600');
@endphp
<body class="min-h-screen bg-bg-light text-text-primary">
    <div class="min-h-screen bg-bg-light">
        <div id="admin-sidebar-overlay" class="fixed inset-0 z-40 hidden bg-black/50 lg:hidden"></div>

        <aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-50 flex w-[260px] -translate-x-full flex-col border-r border-border bg-white transition-transform duration-300 lg:translate-x-0">
            <div class="flex items-center justify-center border-b border-border px-6 py-6">
                <a href="{{ route('admin.dashboard') }}" class="block">
                    <div class="text-center font-heading text-xl font-bold text-text-primary">Cosmex Admin</div>
                </a>
            </div>

            <nav class="flex-1 space-y-1.5 overflow-y-auto px-4 py-6">
                <a href="{{ route('admin.dashboard') }}" class="{{ $navLinkClasses(request()->routeIs('admin.dashboard')) }}">
                    <svg class="{{ $iconClasses(request()->routeIs('admin.dashboard')) }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3.75 3.75h6.5v6.5h-6.5zm10 0h6.5v6.5h-6.5zm-10 10h6.5v6.5h-6.5zm10 2h6.5v4.5h-6.5z" /></svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.products.index') }}" class="{{ $navLinkClasses(request()->routeIs('admin.products.*') && ! request()->routeIs('admin.products.import*')) }}">
                    <svg class="{{ $iconClasses(request()->routeIs('admin.products.*') && ! request()->routeIs('admin.products.import*')) }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="m3.75 7.5 8.25-3.75 8.25 3.75-8.25 3.75zm0 0v9l8.25 3.75 8.25-3.75v-9m-8.25 3.75v9" /></svg>
                    <span>Products</span>
                </a>
                <a href="{{ route('admin.categories.index') }}" class="{{ $navLinkClasses(request()->routeIs('admin.categories.*')) }}">
                    <svg class="{{ $iconClasses(request()->routeIs('admin.categories.*')) }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="m20.25 12-8.5 8.5a2.121 2.121 0 0 1-3 0l-5.25-5.25a2.121 2.121 0 0 1 0-3l8.5-8.5h5.25a3 3 0 0 1 3 3z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15.75 8.25h.008v.008h-.008z" /></svg>
                    <span>Categories</span>
                </a>
                <a href="{{ route('admin.products.import') }}" class="{{ $navLinkClasses(request()->routeIs('admin.products.import*')) }}">
                    <svg class="{{ $iconClasses(request()->routeIs('admin.products.import*')) }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 16.5V6.75m0 0-3.75 3.75M12 6.75l3.75 3.75M3.75 15v2.25A2.25 2.25 0 0 0 6 19.5h12a2.25 2.25 0 0 0 2.25-2.25V15" /></svg>
                    <span>Import CSV</span>
                </a>

                <div class="my-5 border-t border-zinc-100"></div>

                <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" class="{{ $navLinkClasses(false) }}">
                    <svg class="{{ $iconClasses(false) }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 6H18m0 0v4.5M18 6l-6.75 6.75M9 6H6.75A2.25 2.25 0 0 0 4.5 8.25v9A2.25 2.25 0 0 0 6.75 19.5h9A2.25 2.25 0 0 0 18 17.25V15" /></svg>
                    <span>View Website</span>
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="{{ $navLinkClasses(false) }} w-full">
                        <svg class="{{ $iconClasses(false) }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-7.5a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 6 21h7.5a2.25 2.25 0 0 0 2.25-2.25V15m-6-3h10.5m0 0-3-3m3 3-3 3" /></svg>
                        <span>Logout</span>
                    </button>
                </form>
            </nav>
        </aside>

        <div class="lg:pl-[260px]">
            <header class="sticky top-0 z-30 border-b border-border bg-white/90 backdrop-blur-xl">
                <div class="flex items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                    <div class="flex items-center gap-4">
                        <button id="admin-sidebar-toggle" type="button" class="inline-flex h-11 w-11 items-center justify-center rounded-lg border border-zinc-200 text-zinc-700 lg:hidden">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
                        </button>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest text-zinc-500">Admin Portal</p>
                            <h1 class="text-xl font-bold text-text-primary">{{ $pageTitle }}</h1>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 rounded-full border border-zinc-200 bg-white px-3 py-2 shadow-sm">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-semibold text-text-primary">{{ $adminUser?->name ?? 'Admin' }}</p>
                            <p class="text-xs text-zinc-500">{{ $adminUser?->email ?? 'admin@cosmexpvtltd.com' }}</p>
                        </div>
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-primary text-sm font-bold text-white">
                            {{ strtoupper(substr($adminUser?->name ?? 'A', 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            <main class="min-h-[calc(100vh-89px)] px-4 py-8 sm:px-6 lg:px-8">
                @if (session('success'))
                    <div class="mb-6 rounded-lg border border-primary bg-primary/10 px-5 py-4 text-sm text-text-primary font-medium shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 rounded-lg border border-red-300 bg-red-50 px-5 py-4 text-sm text-red-700 shadow-sm">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 rounded-lg border border-red-300 bg-red-50 px-5 py-4 text-sm text-red-700 shadow-sm">
                        {{ $errors->first() }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        (() => {
            const sidebar = document.getElementById('admin-sidebar');
            const overlay = document.getElementById('admin-sidebar-overlay');
            const toggle = document.getElementById('admin-sidebar-toggle');

            if (!sidebar || !overlay || !toggle) return;

            const openSidebar = () => {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            };

            const closeSidebar = () => {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            };

            toggle.addEventListener('click', () => {
                if (sidebar.classList.contains('-translate-x-full')) {
                    openSidebar();
                } else {
                    closeSidebar();
                }
            });

            overlay.addEventListener('click', closeSidebar);
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1024) {
                    overlay.classList.add('hidden');
                    sidebar.classList.remove('-translate-x-full');
                } else {
                    sidebar.classList.add('-translate-x-full');
                }
            });
        })();
    </script>

    @stack('scripts')
</body>
</html>
