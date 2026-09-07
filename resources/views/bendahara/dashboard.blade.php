@extends('layouts.app')

@section('title', 'Dashboard Bendahara')

@section('breadcrumb', 'Bendahara')

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
        Selamat datang kembali,
    </p>

    <h1 class="mt-1 text-2xl font-extrabold text-slate-900">
        {{ auth()->user()->name }} 👋
    </h1>

    <p class="mt-2 text-sm font-semibold text-indigo-600">
        Data bulan {{ now()->translatedFormat('F Y') }}
    </p>

</div>


<!-- SUMMARY -->

<div class="mb-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">

    <div class="relative overflow-hidden rounded-2xl bg-indigo-600 p-6 text-white shadow-xl shadow-indigo-100">

        <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-white/10"></div>

        <div class="relative">

            <div class="mb-6 flex items-center justify-between">

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-white/15">

                    <i data-lucide="wallet" class="h-6 w-6"></i>

                </div>

                <span class="rounded-full bg-white/15 px-3 py-1 text-xs font-bold">
                    Bendahara
                </span>

            </div>

            <p class="text-sm text-indigo-200">
                Total Transaksi
            </p>

            <h2 class="mt-2 text-3xl font-extrabold">
                {{ $kas->total() }}
            </h2>

            <p class="mt-2 text-xs text-indigo-200">
                Transaksi tercatat dalam kelas
            </p>

        </div>

    </div>


    <div class="stat-card">

        <div class="stat-icon bg-emerald-50 text-emerald-600">

            <i data-lucide="arrow-down-left" class="h-6 w-6"></i>

        </div>

        <p class="mt-5 text-sm text-slate-400">
            Status Sistem
        </p>

        <h3 class="mt-1 text-xl font-extrabold text-slate-900">
            Berjalan
        </h3>

        <span class="mt-3 inline-flex items-center gap-1 text-xs font-semibold text-emerald-600">

            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>

            Sistem aktif

        </span>

    </div>


    <div class="stat-card">

        <div class="stat-icon bg-violet-50 text-violet-600">

            <i data-lucide="users" class="h-6 w-6"></i>

        </div>

        <p class="mt-5 text-sm text-slate-400">
            Kelas
        </p>

        <h3 class="mt-1 text-xl font-extrabold text-slate-900">
            {{ auth()->user()->kelas_id ?? '-' }}
        </h3>

    </div>

    <div class="stat-card">

        <div class="stat-icon bg-emerald-50 text-emerald-600">
            <i data-lucide="wallet" class="h-6 w-6"></i>
        </div>

        <p class="mt-5 text-sm text-slate-400">Saldo Kas</p>

        <h3 class="mt-1 text-xl font-extrabold text-slate-900">
            Rp {{ number_format($saldoKas, 0, ',', '.') }}
        </h3>

    </div>

</div>


<div class="mb-8 grid gap-5 lg:grid-cols-2">

    <div id="input-kas" class="card p-6">
        <h2 class="text-lg font-extrabold text-slate-900">Input Kas</h2>
        <p class="mt-1 text-sm text-slate-500">Catat pemasukan atau pengeluaran kas kelas.</p>

        <form method="POST" action="{{ route('bendahara.kas.store') }}" class="mt-5 space-y-4">
            @csrf
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="form-label">Tipe</label>
                    <select name="tipe" class="form-select" required>
                        <option value="pemasukan">Pemasukan</option>
                        <option value="pengeluaran">Pengeluaran</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Jumlah</label>
                    <input type="number" name="jumlah" min="1" value="{{ old('jumlah') }}" class="form-input" required>
                </div>
            </div>
            <div>
                <label class="form-label">Siswa Penabung</label>
                <select name="siswa_id" class="form-select">
                    <option value="">Pilih siswa untuk pemasukan</option>
                    @foreach($siswas as $siswa)
                        <option value="{{ $siswa->id }}" @selected(old('siswa_id') == $siswa->id)>
                            {{ $siswa->name }} ({{ $siswa->email }})
                        </option>
                    @endforeach
                </select>
                <p class="mt-1 text-xs text-slate-400">Wajib dipilih jika tipe transaksi adalah pemasukan.</p>
            </div>
            <div>
                <label class="form-label">Tanggal</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', now()->toDateString()) }}" class="form-input" required>
            </div>
            <div>
                <label class="form-label">Keterangan</label>
                <input type="text" name="keterangan" value="{{ old('keterangan') }}" class="form-input" maxlength="255">
            </div>
            <button type="submit" class="btn-primary w-full">
                <i data-lucide="plus" class="h-4 w-4"></i>
                Simpan Kas
            </button>
        </form>
    </div>

    <div id="buat-voting" class="card p-6">
        <h2 class="text-lg font-extrabold text-slate-900">Buat Voting Barang</h2>
        <p class="mt-1 text-sm text-slate-500">Barang yang disetujui akan otomatis dicatat sebagai pengeluaran.</p>

        <form method="POST" action="{{ route('bendahara.vote-items.store') }}" enctype="multipart/form-data" class="mt-5 space-y-4">
            @csrf
            <div>
                <label class="form-label">Nama Barang</label>
                <input type="text" name="nama_item" class="form-input" maxlength="255" required>
            </div>
            <div>
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-input" rows="2" required></textarea>
            </div>
            <div>
                <label class="form-label">Gambar (Opsional)</label>
                <input type="file" name="gambar" accept="image/jpeg,image/png,image/webp" class="form-input">
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="form-label">Harga</label>
                    <input type="number" name="harga" min="1" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">Voting Berakhir</label>
                    <input type="date" name="aktif_hingga" min="{{ now()->toDateString() }}" class="form-input" required>
                </div>
            </div>
            <button type="submit" class="btn-primary w-full">
                <i data-lucide="vote" class="h-4 w-4"></i>
                Buat Voting
            </button>
        </form>
    </div>

</div>


<div class="card mb-8 overflow-hidden">
    <div class="border-b border-slate-100 p-5">
        <h2 class="font-extrabold text-slate-900">Persetujuan Barang</h2>
        <p class="mt-1 text-xs text-slate-400">ACC barang akan mengurangi saldo kas sesuai harga.</p>
    </div>
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Barang</th>
                    <th>Bulan</th>
                    <th>Harga</th>
                    <th>ACC</th>
                    <th>Tidak ACC</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($voteItems as $item)
                    <tr>
                        <td>
                            <p class="font-bold text-slate-800">{{ $item->nama_item }}</p>
                            <p class="text-xs text-slate-400">{{ $item->deskripsi }}</p>
                        </td>
                        <td>{{ $item->created_at->translatedFormat('F Y') }}</td>
                        <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td>{{ $item->acc_votes_count }}</td>
                        <td>{{ $item->tidak_acc_votes_count }}</td>
                        <td>{{ ucfirst($item->status) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="py-8 text-center text-sm text-slate-400">Belum ada voting barang.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


<!-- TABLE -->

<div class="card overflow-hidden">

    <div class="border-b border-slate-100 p-5">

        <h2 class="font-extrabold text-slate-900">
            Riwayat Kas Kelas
        </h2>

        <p class="mt-1 text-xs text-slate-400">
            Pantau seluruh aktivitas transaksi kelas.
        </p>

    </div>


    <div class="overflow-x-auto">

        <table class="data-table">

            <thead>

                <tr>

                    <th>
                        Tanggal
                    </th>

                    <th>
                        Tipe
                    </th>

                    <th>
                        Siswa
                    </th>

                    <th>
                        Jumlah
                    </th>

                    <th>
                        Keterangan
                    </th>

                </tr>

            </thead>

            <tbody>

            @forelse ($kas as $trans)

                <tr>

                    <td class="font-medium text-slate-700">
                        {{ $trans->tanggal }}
                    </td>

                    <td>

                        @if(strtolower($trans->tipe) === 'masuk')

                            <span class="badge badge-success">
                                Masuk
                            </span>

                        @else

                            <span class="badge badge-danger">
                                {{ ucfirst($trans->tipe) }}
                            </span>

                        @endif

                    </td>

                    <td>
                        {{ $trans->siswa?->name ?? '-' }}
                    </td>

                    <td class="font-bold text-slate-800">

                        Rp {{ number_format($trans->jumlah, 0, ',', '.') }}

                    </td>

                    <td>
                        {{ $trans->keterangan }}
                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="5">

                        <div class="py-12 text-center">

                            <i data-lucide="inbox"
                               class="mx-auto h-8 w-8 text-slate-300">
                            </i>

                            <p class="mt-3 font-semibold text-slate-600">
                                Belum ada transaksi
                            </p>

                            <p class="mt-1 text-sm text-slate-400">
                                Data transaksi akan muncul di sini.
                            </p>

                        </div>

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>


    @if($kas->hasPages())

        <div class="border-t border-slate-100 p-5">

            {{ $kas->links() }}

        </div>

    @endif

</div>

@endsection