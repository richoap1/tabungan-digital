@extends('layouts.app')

@section('title', 'Voting Barang')
@section('breadcrumb', 'Bendahara / Voting Barang')
@section('header', 'Voting Barang')

@section('content')
@if(session('success'))
    <div class="mb-6 rounded-xl bg-emerald-50 p-4 text-sm font-semibold text-emerald-700">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="mb-6 rounded-xl bg-rose-50 p-4 text-sm text-rose-700">
        @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
    </div>
@endif

<div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
    <div>
        <p class="text-sm text-slate-500">Voting bulan berjalan</p>
        <h1 class="mt-1 text-2xl font-extrabold text-slate-900">Kelola Voting Barang</h1>
    </div>
    <a href="{{ route('bendahara.dashboard') }}" class="btn-secondary">
        <i data-lucide="layout-dashboard" class="h-4 w-4"></i>
        Dashboard
    </a>
</div>

<div class="mb-8 card p-6">
    <h2 class="text-lg font-extrabold text-slate-900">Buat Voting Barang</h2>
    <p class="mt-1 text-sm text-slate-500">Setelah siswa memilih, guru akan memeriksa suara dan menyetujui pembelian.</p>

    <form method="POST" action="{{ route('bendahara.vote-items.store') }}" enctype="multipart/form-data" class="mt-5 grid gap-4 lg:grid-cols-4">
        @csrf
        <div>
            <label class="form-label">Nama Barang</label>
            <input type="text" name="nama_item" class="form-input" maxlength="255" required>
        </div>
        <div>
            <label class="form-label">Harga</label>
            <input type="number" name="harga" min="1" class="form-input" required>
        </div>
        <div>
            <label class="form-label">Berakhir</label>
            <input type="date" name="aktif_hingga" min="{{ now()->toDateString() }}" class="form-input" required>
        </div>
        <div>
            <label class="form-label">Gambar (Opsional)</label>
            <input type="file" name="gambar" accept="image/jpeg,image/png,image/webp" class="form-input">
        </div>
        <div class="flex items-end">
            <button type="submit" class="btn-primary w-full">
                <i data-lucide="plus" class="h-4 w-4"></i>
                Buat Voting
            </button>
        </div>
        <div class="lg:col-span-4">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" rows="2" class="form-input" required></textarea>
        </div>
    </form>
</div>

<div class="card overflow-hidden">
    <div class="border-b border-slate-100 p-5">
        <h2 class="font-extrabold text-slate-900">Daftar Voting Bulan Ini</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead><tr><th>Barang</th><th>Harga</th><th>ACC</th><th>Tidak ACC</th><th>Status</th></tr></thead>
            <tbody>
                @forelse($voteItems as $item)
                    <tr>
                        <td>
                            <p class="font-bold text-slate-800">{{ $item->nama_item }}</p>
                            <p class="text-xs text-slate-400">{{ $item->deskripsi }}</p>
                        </td>
                        <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td>{{ $item->acc_votes_count }}</td>
                        <td>{{ $item->tidak_acc_votes_count }}</td>
                        <td>{{ ucfirst($item->status) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-10 text-center text-sm text-slate-400">Belum ada voting bulan ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
