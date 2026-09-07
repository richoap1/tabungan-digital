<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Tabungan Digital')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/lucide@latest"></script>

    @stack('styles')
</head>

<body>

@auth

<div class="app-shell">

    <!-- ================= SIDEBAR ================= -->

    <aside id="sidebar" class="sidebar">

        <div class="sidebar-brand">

            <div class="brand-icon">
                <i data-lucide="wallet" class="h-6 w-6"></i>
            </div>

            <div>
                <h1 class="text-base font-extrabold text-slate-900">
                    Tabungan Digital
                </h1>

                <p class="text-xs text-slate-400">
                    Smart Class Finance
                </p>
            </div>

        </div>


        <!-- Navigation -->

        <nav class="sidebar-nav">

            <p class="nav-section-title">
                Menu Utama
            </p>

            @if(auth()->user()->role === 'siswa')

                <a href="{{ route('siswa.dashboard') }}"
                   class="nav-link {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">

                    <span class="nav-icon">
                        <i data-lucide="layout-dashboard" class="h-5 w-5"></i>
                    </span>

                    <span>Dashboard</span>

                </a>

                <a href="{{ route('vote.index') }}"
                   class="nav-link {{ request()->routeIs('vote.*') ? 'active' : '' }}">

                    <span class="nav-icon">
                        <i data-lucide="vote" class="h-5 w-5"></i>
                    </span>

                    <span>Voting Barang</span>

                </a>

            @elseif(auth()->user()->role === 'bendahara')

                <a href="{{ route('bendahara.dashboard') }}"
                   class="nav-link {{ request()->routeIs('bendahara.dashboard') ? 'active' : '' }}">

                    <span class="nav-icon">
                        <i data-lucide="layout-dashboard" class="h-5 w-5"></i>
                    </span>

                    <span>Dashboard</span>

                </a>

                     <a href="{{ route('bendahara.transactions') }}"
                         class="nav-link">

                    <span class="nav-icon">
                        <i data-lucide="arrow-left-right" class="h-5 w-5"></i>
                    </span>

                    <span>Transaksi</span>

                </a>

                <a href="{{ route('bendahara.voting') }}"
                   class="nav-link">

                    <span class="nav-icon">
                        <i data-lucide="vote" class="h-5 w-5"></i>
                    </span>

                    <span>Voting Barang</span>

                </a>

            @elseif(auth()->user()->role === 'guru')

                <a href="{{ route('guru.dashboard') }}"
                   class="nav-link {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">

                    <span class="nav-icon">
                        <i data-lucide="layout-dashboard" class="h-5 w-5"></i>
                    </span>

                    <span>Dashboard</span>

                </a>

                <a href="{{ route('guru.dashboard') }}#manajemen-kelas"
                   class="nav-link">

                    <span class="nav-icon">
                        <i data-lucide="users-round" class="h-5 w-5"></i>
                    </span>

                    <span>Manajemen Kelas</span>

                </a>

            @elseif(auth()->user()->role === 'admin')

                <a href="{{ route('admin.dashboard') }}"
                   class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="nav-icon"><i data-lucide="layout-dashboard" class="h-5 w-5"></i></span>
                    <span>Dashboard Admin</span>
                </a>

                <a href="{{ route('bendahara.transactions') }}" class="nav-link">
                    <span class="nav-icon"><i data-lucide="arrow-left-right" class="h-5 w-5"></i></span>
                    <span>Transaksi</span>
                </a>

                <a href="{{ route('bendahara.voting') }}" class="nav-link">
                    <span class="nav-icon"><i data-lucide="vote" class="h-5 w-5"></i></span>
                    <span>Voting Barang</span>
                </a>

                <a href="{{ route('guru.dashboard') }}" class="nav-link">
                    <span class="nav-icon"><i data-lucide="users-round" class="h-5 w-5"></i></span>
                    <span>Manajemen Kelas</span>
                </a>

                <a href="{{ route('vote.index') }}" class="nav-link">
                    <span class="nav-icon"><i data-lucide="check-check" class="h-5 w-5"></i></span>
                    <span>Voting Siswa</span>
                </a>

            @endif


            <div class="mt-8">

                <p class="nav-section-title">
                    Akun
                </p>

                     <a href="{{ route('profile') }}"
                         class="nav-link {{ request()->routeIs('profile*') ? 'active' : '' }}">

                    <span class="nav-icon">
                        <i data-lucide="user" class="h-5 w-5"></i>
                    </span>

                    <span>Profil</span>

                </a>

                     <a href="{{ route('settings') }}"
                         class="nav-link {{ request()->routeIs('settings*') ? 'active' : '' }}">

                    <span class="nav-icon">
                        <i data-lucide="settings" class="h-5 w-5"></i>
                    </span>

                    <span>Pengaturan</span>

                </a>

            </div>

        </nav>


        <!-- User Card -->

        <div class="border-t border-slate-100 p-4">

            <div class="flex items-center gap-3 rounded-xl bg-slate-50 p-3">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-indigo-100 font-bold text-indigo-600">

                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                </div>

                <div class="min-w-0 flex-1">

                    <p class="truncate text-sm font-bold text-slate-800">
                        {{ auth()->user()->name }}
                    </p>

                    <p class="truncate text-xs capitalize text-slate-400">
                        {{ auth()->user()->role }}
                    </p>

                </div>

                <form method="POST" action="{{ route('logout') }}">

                    @csrf

                    <button type="submit"
                            title="Logout"
                            class="rounded-lg p-2 text-slate-400 transition hover:bg-red-50 hover:text-red-500">

                        <i data-lucide="log-out" class="h-4 w-4"></i>

                    </button>

                </form>

            </div>

        </div>

    </aside>


    <!-- ================= MAIN ================= -->

    <div class="main-content">

        <!-- TOPBAR -->

        <header class="topbar">

            <div class="flex items-center gap-3">

                <button id="mobileMenuButton"
                        class="mobile-menu-button">

                    <i data-lucide="menu" class="h-5 w-5"></i>

                </button>

                <div>

                    <p class="text-xs font-medium text-slate-400">
                        @yield('breadcrumb', 'Overview')
                    </p>

                    <h2 class="text-lg font-bold text-slate-800">
                        @yield('header', 'Dashboard')
                    </h2>

                </div>

            </div>


            <div class="flex items-center gap-3">

                <!-- Notification -->

                <button class="relative rounded-xl p-2.5 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700">

                    <i data-lucide="bell" class="h-5 w-5"></i>

                    <span class="absolute right-2 top-2 h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>

                </button>


                <!-- Avatar -->

                <div class="hidden items-center gap-3 border-l border-slate-200 pl-4 sm:flex">

                    <div class="text-right">

                        <p class="text-sm font-semibold text-slate-700">
                            {{ auth()->user()->name }}
                        </p>

                        <p class="text-xs capitalize text-slate-400">
                            {{ auth()->user()->role }}
                        </p>

                    </div>

                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-600 font-bold text-white">

                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                    </div>

                </div>

            </div>

        </header>


        <!-- PAGE -->

        <main class="page-content">

            @if(session('success'))

                <div class="alert alert-success">

                    <i data-lucide="check-circle" class="mt-0.5 h-5 w-5"></i>

                    <span>{{ session('success') }}</span>

                </div>

            @endif


            @if($errors->any())

                <div class="alert alert-error">

                    <i data-lucide="alert-circle" class="mt-0.5 h-5 w-5"></i>

                    <div>

                        @foreach($errors->all() as $error)

                            <p>{{ $error }}</p>

                        @endforeach

                    </div>

                </div>

            @endif

            @yield('content')

        </main>

    </div>

</div>

@else

    @yield('content')

@endauth


<script>
    document.addEventListener('DOMContentLoaded', function () {

        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        const button = document.getElementById('mobileMenuButton');
        const sidebar = document.getElementById('sidebar');

        if (button && sidebar) {
            button.addEventListener('click', function () {
                sidebar.classList.toggle('open');
            });
        }

    });
</script>

@stack('scripts')

</body>
</html>