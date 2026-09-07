@extends('layouts.app')

@section('title', 'Transaksi Kas')
@section('breadcrumb', 'Bendahara / Transaksi')
@section('header', 'Transaksi Kas')

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
        <p class="text-sm text-slate-500">Periode otomatis</p>
        <h1 class="mt-1 text-2xl font-extrabold text-slate-900">Kas bulan {{ now()->translatedFormat('F Y') }}</h1>
    </div>
    <div class="rounded-2xl bg-indigo-600 px-6 py-4 text-white shadow-lg shadow-indigo-100">
        <p class="text-xs text-indigo-200">Saldo bulan ini</p>
        <p class="mt-1 text-2xl font-extrabold">Rp {{ number_format($saldoKas, 0, ',', '.') }}</p>
    </div>
</div>

<div class="mb-8 card p-6">
    <h2 class="text-lg font-extrabold text-slate-900">Input Transaksi</h2>
    <p class="mt-1 text-sm text-slate-500">Pemasukan wajib dikaitkan dengan siswa yang menabung.</p>

    <form method="POST" action="{{ route('bendahara.kas.store') }}" class="mt-5 grid gap-4 lg:grid-cols-4">
        @csrf
        <div>
            <label class="form-label">Tipe</label>
            <select name="tipe" class="form-select" required>
                <option value="pemasukan">Pemasukan</option>
                <option value="pengeluaran">Pengeluaran</option>
            </select>
        </div>
        <div>
            <label class="form-label">Siswa Penabung</label>
            <select name="siswa_id" class="form-select">
                <option value="">Pilih siswa</option>
                @foreach($siswas as $siswa)
                    <option value="{{ $siswa->id }}">{{ $siswa->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="form-label">Jumlah</label>
            <input type="number" name="jumlah" min="1" class="form-input" required>
        </div>
        <div>
            <label class="form-label">Tanggal</label>
            <input type="date" name="tanggal" value="{{ now()->toDateString() }}" class="form-input" required>
        </div>
        <div class="lg:col-span-3">
            <label class="form-label">Keterangan</label>
            <input type="text" name="keterangan" maxlength="255" class="form-input">
        </div>
        <div class="flex items-end">
            <button type="submit" class="btn-primary w-full">
                <i data-lucide="plus" class="h-4 w-4"></i>
                Simpan Transaksi
            </button>
        </div>
    </form>
</div>

<div class="card overflow-hidden">
    <div class="border-b border-slate-100 p-5">
        <h2 class="font-extrabold text-slate-900">Riwayat Transaksi</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead><tr><th>Tanggal</th><th>Tipe</th><th>Siswa</th><th>Jumlah</th><th>Keterangan</th></tr></thead>
            <tbody>
                @forelse($kas as $transaction)
                    <tr>
                        <td>{{ $transaction->tanggal->format('d/m/Y') }}</td>
                        <td>{{ ucfirst($transaction->tipe) }}</td>
                        <td>{{ $transaction->siswa?->name ?? '-' }}</td>
                        <td class="font-bold">Rp {{ number_format($transaction->jumlah, 0, ',', '.') }}</td>
                        <td>{{ $transaction->keterangan ?? '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-10 text-center text-sm text-slate-400">Belum ada transaksi bulan ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($kas->hasPages())
        <div class="border-t border-slate-100 p-5">{{ $kas->links() }}</div>
    @endif
</div>
@endsection
