@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('breadcrumb', 'Guru')

@section('header', 'Dashboard')

@section('content')

@if(session('success'))
    <div class="mb-6 rounded-xl bg-emerald-50 p-4 text-sm font-semibold text-emerald-700">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="mb-6 rounded-xl bg-rose-50 p-4 text-sm text-rose-700">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

<div class="mb-8">

    <p class="text-sm text-slate-500">
        Selamat datang,
    </p>

    <h1 class="mt-1 text-2xl font-extrabold text-slate-900">
        {{ auth()->user()->name }} 👋
    </h1>

</div>


<div class="grid gap-5 lg:grid-cols-3">

    <!-- CLASS CARD -->

    <div class="relative overflow-hidden rounded-2xl bg-indigo-600 p-7 text-white shadow-xl shadow-indigo-100 lg:col-span-2">

        <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-white/10"></div>

        <div class="relative">

            <div class="mb-8 flex items-center justify-between">

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/15">

                    <i data-lucide="graduation-cap" class="h-6 w-6"></i>

                </div>

                <span class="rounded-full bg-white/15 px-3 py-1 text-xs font-bold">
                    Guru
                </span>

            </div>

            <p class="text-sm text-indigo-200">
                Kelas yang Anda kelola
            </p>

            <h2 class="mt-2 text-4xl font-extrabold">
                {{ auth()->user()->kelas?->nama_kelas ?? 'Belum memilih kelas' }}
            </h2>

            <p class="mt-4 max-w-md text-sm leading-6 text-indigo-100">
                Pantau aktivitas tabungan siswa dan perkembangan
                keuangan kelas melalui sistem Tabungan Digital.
            </p>

        </div>

    </div>


    <!-- STATUS -->

    <div class="card p-6">

        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">

            <i data-lucide="shield-check" class="h-6 w-6"></i>

        </div>

        <p class="mt-6 text-sm text-slate-400">
            Status Akun
        </p>

        <h3 class="mt-1 text-xl font-extrabold text-slate-900">
            Aktif
        </h3>

        <div class="mt-4 flex items-center gap-2 text-xs font-semibold text-emerald-600">

            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>

            Sistem berjalan normal

        </div>

    </div>

</div>


<div id="manajemen-kelas" class="mt-6 grid gap-5 lg:grid-cols-2">

    <div class="card p-6">
        <h2 class="text-lg font-extrabold text-slate-900">Tambah Kelas</h2>
        <p class="mt-1 text-sm text-slate-500">Buat kelas baru untuk dikelola.</p>

        <form method="POST" action="{{ route('guru.classes.store') }}" class="mt-5 flex gap-3">
            @csrf
            <input type="text" name="nama_kelas" class="form-input" placeholder="Contoh: XI IPA 1" maxlength="255" required>
            <button type="submit" class="btn-primary shrink-0">
                <i data-lucide="plus" class="h-4 w-4"></i>
                Tambah
            </button>
        </form>
    </div>

    <div class="card p-6">
        <h2 class="text-lg font-extrabold text-slate-900">Kelas Saya</h2>
        <p class="mt-1 text-sm text-slate-500">Pilih kelas yang dikelola oleh akun guru ini.</p>

        <form method="POST" action="{{ route('guru.users.class.update', auth()->id()) }}" class="mt-5 flex gap-3">
            @csrf
            @method('PATCH')
            <select name="kelas_id" class="form-select" required>
                <option value="">Pilih kelas</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" @selected($kelas == $class->id)>
                        {{ $class->nama_kelas }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn-primary shrink-0">
                <i data-lucide="check" class="h-4 w-4"></i>
                Simpan
            </button>
        </form>
    </div>

</div>


<div class="mt-6 card overflow-hidden">
    <div class="border-b border-slate-100 p-5">
        <h2 class="font-extrabold text-slate-900">Daftar Kelas</h2>
        <p class="mt-1 text-xs text-slate-400">Jumlah pengguna pada setiap kelas.</p>
    </div>
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Kelas</th>
                    <th>Jumlah Pengguna</th>
                </tr>
            </thead>
            <tbody>
                @forelse($classes as $class)
                    <tr>
                        <td class="font-bold text-slate-800">{{ $class->nama_kelas }}</td>
                        <td>{{ $class->users_count }}</td>
                    </tr>
                @empty
                    <tr><td colspan="2" class="py-8 text-center text-sm text-slate-400">Belum ada kelas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


<div class="mt-6 grid gap-5 xl:grid-cols-2">

    <div class="card overflow-hidden">
        <div class="border-b border-slate-100 p-5">
            <h2 class="font-extrabold text-slate-900">Atur Kelas Siswa</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead><tr><th>Nama</th><th>Kelas</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse($students as $student)
                        <tr>
                            <td>
                                <p class="font-bold text-slate-800">{{ $student->name }}</p>
                                <p class="text-xs text-slate-400">{{ $student->email }}</p>
                            </td>
                            <td>{{ $student->kelas?->nama_kelas ?? '-' }}</td>
                            <td>
                                <form method="POST" action="{{ route('guru.users.class.update', $student) }}" class="flex gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="kelas_id" class="form-select min-w-36" required>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}" @selected($student->kelas_id == $class->id)>{{ $class->nama_kelas }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn-secondary shrink-0" title="Simpan kelas">
                                        <i data-lucide="save" class="h-4 w-4"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="py-8 text-center text-sm text-slate-400">Belum ada siswa.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card overflow-hidden">
        <div class="border-b border-slate-100 p-5">
            <h2 class="font-extrabold text-slate-900">Atur Kelas Bendahara</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead><tr><th>Nama</th><th>Kelas</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse($treasurers as $treasurer)
                        <tr>
                            <td>
                                <p class="font-bold text-slate-800">{{ $treasurer->name }}</p>
                                <p class="text-xs text-slate-400">{{ $treasurer->email }}</p>
                            </td>
                            <td>{{ $treasurer->kelas?->nama_kelas ?? '-' }}</td>
                            <td>
                                <form method="POST" action="{{ route('guru.users.class.update', $treasurer) }}" class="flex gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="kelas_id" class="form-select min-w-36" required>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}" @selected($treasurer->kelas_id == $class->id)>{{ $class->nama_kelas }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn-secondary shrink-0" title="Simpan kelas">
                                        <i data-lucide="save" class="h-4 w-4"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="py-8 text-center text-sm text-slate-400">Belum ada bendahara.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>


<div class="mt-6 card overflow-hidden">
    <div class="border-b border-slate-100 p-5">
        <h2 class="font-extrabold text-slate-900">Persetujuan Voting Barang</h2>
        <p class="mt-1 text-xs text-slate-400">Periksa suara siswa. ACC guru akan mengubah status dan mengurangi kas.</p>
    </div>
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Barang</th>
                    <th>Harga</th>
                    <th>ACC</th>
                    <th>Tidak ACC</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($voteItems as $item)
                    <tr>
                        <td>
                            @if($item->gambar)
                                <img src="{{ asset('storage/'.$item->gambar) }}" alt="{{ $item->nama_item }}" class="mb-2 h-16 w-24 rounded-lg object-cover">
                            @endif
                            <p class="font-bold text-slate-800">{{ $item->nama_item }}</p>
                            <p class="text-xs text-slate-400">{{ $item->deskripsi }}</p>
                        </td>
                        <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td>{{ $item->acc_votes_count }}</td>
                        <td>{{ $item->tidak_acc_votes_count }}</td>
                        <td>{{ ucfirst($item->status) }}</td>
                        <td>
                            @if($item->status === 'menunggu')
                                <form method="POST" action="{{ route('guru.vote-items.approve', $item) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-primary">
                                        <i data-lucide="shield-check" class="h-4 w-4"></i>
                                        ACC Guru
                                    </button>
                                </form>
                            @else
                                <span class="text-xs text-slate-400">Sudah diproses</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="py-8 text-center text-sm text-slate-400">Belum ada voting untuk kelas Anda.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


<div class="mt-6 card p-6">

    <div class="flex items-start gap-4">

        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">

            <i data-lucide="info" class="h-5 w-5"></i>

        </div>

        <div>

            <h3 class="font-bold text-slate-800">
                Informasi Kelas
            </h3>

            <p class="mt-1 text-sm leading-6 text-slate-500">
                Anda saat ini terhubung dengan kelas
                <strong>{{ auth()->user()->kelas?->nama_kelas ?? '-' }}</strong>.
                Gunakan dashboard untuk memantau aktivitas
                tabungan kelas.
            </p>

        </div>

    </div>

</div>

@endsection