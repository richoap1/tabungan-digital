@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('breadcrumb', 'Admin')
@section('header', 'Dashboard Admin')

@section('content')
<div class="mb-8">
    <p class="text-sm text-slate-500">Selamat datang,</p>
    <h1 class="mt-1 text-2xl font-extrabold text-slate-900">{{ auth()->user()->name }}</h1>
    <p class="mt-2 text-sm text-slate-500">Admin dapat mengakses seluruh alur siswa, bendahara, dan guru.</p>
</div>

<div class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
    <a href="{{ route('bendahara.transactions') }}" class="card p-6 transition hover:-translate-y-1 hover:shadow-lg">
        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600"><i data-lucide="arrow-left-right" class="h-5 w-5"></i></div>
        <h2 class="mt-5 font-extrabold text-slate-900">Transaksi Kas</h2>
        <p class="mt-1 text-sm text-slate-500">Input dan pantau kas.</p>
    </a>
    <a href="{{ route('bendahara.voting') }}" class="card p-6 transition hover:-translate-y-1 hover:shadow-lg">
        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600"><i data-lucide="vote" class="h-5 w-5"></i></div>
        <h2 class="mt-5 font-extrabold text-slate-900">Voting Barang</h2>
        <p class="mt-1 text-sm text-slate-500">Buat dan pantau voting.</p>
    </a>
    <a href="{{ route('guru.dashboard') }}" class="card p-6 transition hover:-translate-y-1 hover:shadow-lg">
        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-600"><i data-lucide="graduation-cap" class="h-5 w-5"></i></div>
        <h2 class="mt-5 font-extrabold text-slate-900">Manajemen Guru</h2>
        <p class="mt-1 text-sm text-slate-500">Kelola kelas dan persetujuan.</p>
    </a>
    <a href="{{ route('vote.index') }}" class="card p-6 transition hover:-translate-y-1 hover:shadow-lg">
        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-rose-50 text-rose-600"><i data-lucide="check-check" class="h-5 w-5"></i></div>
        <h2 class="mt-5 font-extrabold text-slate-900">Area Siswa</h2>
        <p class="mt-1 text-sm text-slate-500">Lihat dan isi voting siswa.</p>
    </a>
</div>

<div class="mt-6 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800">
    Pilih kelas Anda melalui halaman Manajemen Guru agar transaksi dan voting berjalan pada kelas yang benar.
</div>
@endsection
