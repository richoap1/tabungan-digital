@extends('layouts.app')

@section('title', 'Dashboard Siswa')
@section('breadcrumb', 'Siswa')
@section('header', 'Dashboard')

@section('content')
<div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
    <div>
        <p class="text-sm text-slate-500">Selamat datang kembali,</p>
        <h1 class="mt-1 text-2xl font-extrabold text-slate-900">{{ auth()->user()->name }} 👋</h1>
    </div>
    <a href="{{ route('vote.index') }}" class="btn-primary"><i data-lucide="vote" class="h-4 w-4"></i>Voting Barang</a>
</div>

<div class="mb-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-5">
    <div class="stat-card">
        <div class="stat-icon bg-indigo-50 text-indigo-600"><i data-lucide="wallet" class="h-6 w-6"></i></div>
        <p class="mt-5 text-sm font-medium text-slate-400">Status Tabungan</p>
        <h3 class="mt-1 text-xl font-extrabold text-slate-900">Aktif</h3>
    </div>
    <div class="stat-card">
        <div class="stat-icon bg-emerald-50 text-emerald-600"><i data-lucide="wallet-cards" class="h-6 w-6"></i></div>
        <p class="mt-5 text-sm font-medium text-slate-400">Total Uang Kas</p>
        <h3 class="mt-1 text-xl font-extrabold text-slate-900">Rp {{ number_format($totalKas, 0, ',', '.') }}</h3>
    </div>
    <div class="stat-card">
        <div class="stat-icon bg-amber-50 text-amber-600"><i data-lucide="arrow-left-right" class="h-6 w-6"></i></div>
        <p class="mt-5 text-sm font-medium text-slate-400">Total Transaksi</p>
        <h3 class="mt-1 text-xl font-extrabold text-slate-900">{{ $transactions->total() }}</h3>
    </div>
    <div class="stat-card">
        <div class="stat-icon bg-violet-50 text-violet-600"><i data-lucide="calendar-days" class="h-6 w-6"></i></div>
        <p class="mt-5 text-sm font-medium text-slate-400">Kelas</p>
        <h3 class="mt-1 text-xl font-extrabold text-slate-900">{{ auth()->user()->kelas?->nama_kelas ?? '-' }}</h3>
    </div>
    <div class="stat-card">
        <div class="stat-icon bg-slate-100 text-slate-600"><i data-lucide="shield-check" class="h-6 w-6"></i></div>
        <p class="mt-5 text-sm font-medium text-slate-400">Akun</p>
        <h3 class="mt-1 text-xl font-extrabold capitalize text-slate-900">{{ auth()->user()->role }}</h3>
    </div>
</div>

<div class="card overflow-hidden">
    <div class="flex flex-col justify-between gap-4 border-b border-slate-100 p-5 sm:flex-row sm:items-center">
        <div>
            <h2 class="font-extrabold text-slate-900">Riwayat Transaksi Kas</h2>
            <p class="mt-1 text-xs text-slate-400">Setoran dan pengeluaran yang tercatat atas nama Anda.</p>
        </div>
        <span class="badge badge-info">{{ $transactions->total() }} transaksi</span>
    </div>
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead><tr><th>Tanggal</th><th>Tipe</th><th>Jumlah</th><th>Keterangan</th></tr></thead>
            <tbody>
                @forelse($transactions as $trans)
                    <tr>
                        <td class="whitespace-nowrap font-medium text-slate-700">{{ $trans->tanggal->format('d/m/Y') }}</td>
                        <td>
                            @if($trans->tipe === 'pemasukan')
                                <span class="badge badge-success"><i data-lucide="arrow-down-left" class="mr-1 h-3 w-3"></i>Pemasukan</span>
                            @else
                                <span class="badge badge-danger"><i data-lucide="arrow-up-right" class="mr-1 h-3 w-3"></i>{{ ucfirst($trans->tipe) }}</span>
                            @endif
                        </td>
                        <td class="whitespace-nowrap font-bold text-slate-800">Rp {{ number_format($trans->jumlah, 0, ',', '.') }}</td>
                        <td>{{ $trans->keterangan ?? '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="py-12 text-center text-sm text-slate-400">Belum ada transaksi kas atas nama Anda.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($transactions->hasPages())
        <div class="border-t border-slate-100 p-5">{{ $transactions->links() }}</div>
    @endif
</div>

<div class="mt-8">
    <div class="mb-5 flex items-end justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-slate-900">Voting Kelas yang Berlangsung</h2>
            <p class="mt-1 text-sm text-slate-500">Berikan pilihanmu sebelum voting berakhir.</p>
        </div>
        <a href="{{ route('vote.index') }}" class="btn-secondary"><i data-lucide="vote" class="h-4 w-4"></i>Lihat Semua</a>
    </div>

    @if($voteItems->count())
        <div class="grid gap-5 md:grid-cols-2">
            @foreach($voteItems as $item)
                @php($currentVote = $item->votes->first())
                <div class="card overflow-hidden">
                    @if($item->gambar)
                        <img src="{{ asset('storage/'.$item->gambar) }}" alt="{{ $item->nama_item }}" class="h-40 w-full object-cover">
                    @endif
                    <div class="p-5">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h3 class="font-extrabold text-slate-900">{{ $item->nama_item }}</h3>
                                <p class="mt-1 text-sm text-slate-500">{{ $item->deskripsi }}</p>
                            </div>
                            <span class="whitespace-nowrap text-sm font-bold text-slate-800">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                        </div>
                        <div class="mt-4 grid grid-cols-2 gap-2 text-center text-xs">
                            <div class="rounded-lg bg-emerald-50 px-3 py-2 text-emerald-700"><span class="block font-extrabold">{{ $item->acc_votes_count }}</span>ACC</div>
                            <div class="rounded-lg bg-rose-50 px-3 py-2 text-rose-700"><span class="block font-extrabold">{{ $item->tidak_acc_votes_count }}</span>Tidak ACC</div>
                        </div>
                        <p class="mt-4 text-xs text-slate-400">Pilihan Anda: {{ $currentVote ? ($currentVote->pilihan === 'acc' ? 'ACC' : 'Tidak ACC') : 'Belum memilih' }}</p>
                        <form method="POST" action="{{ route('vote.store', $item) }}" class="mt-3 grid grid-cols-2 gap-2">
                            @csrf
                            <button type="submit" name="pilihan" value="acc" class="btn-primary disabled:cursor-not-allowed disabled:opacity-50" @disabled($currentVote)><i data-lucide="check-circle" class="h-4 w-4"></i>ACC</button>
                            <button type="submit" name="pilihan" value="tidak_acc" class="btn-secondary disabled:cursor-not-allowed disabled:opacity-50" @disabled($currentVote)><i data-lucide="x-circle" class="h-4 w-4"></i>Tidak ACC</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card py-10 text-center text-sm text-slate-400">Belum ada voting aktif di kelas Anda.</div>
    @endif
</div>
@endsection
