@extends('layouts.app')

@section('title', 'Pengaturan')
@section('breadcrumb', 'Akun / Pengaturan')
@section('header', 'Pengaturan')

@section('content')
@if(session('success'))
    <div class="mb-6 rounded-xl bg-emerald-50 p-4 text-sm font-semibold text-emerald-700">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="mb-6 rounded-xl bg-rose-50 p-4 text-sm text-rose-700">
        @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
    </div>
@endif

<div class="max-w-2xl">
    <div class="mb-8">
        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-600">
            <i data-lucide="settings" class="h-7 w-7"></i>
        </div>
        <h1 class="mt-4 text-2xl font-extrabold text-slate-900">Pengaturan Akun</h1>
        <p class="mt-1 text-sm text-slate-500">Perbarui password untuk menjaga keamanan akun.</p>
    </div>

    <div class="card p-6">
        <h2 class="text-lg font-extrabold text-slate-900">Ganti Password</h2>
        <form method="POST" action="{{ route('settings.password.update') }}" class="mt-5 space-y-5">
            @csrf
            @method('PATCH')
            <div>
                <label class="form-label">Password Saat Ini</label>
                <input type="password" name="current_password" class="form-input" required>
            </div>
            <div>
                <label class="form-label">Password Baru</label>
                <input type="password" name="password" class="form-input" minlength="6" required>
            </div>
            <div>
                <label class="form-label">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="form-input" minlength="6" required>
            </div>
            <button type="submit" class="btn-primary">
                <i data-lucide="lock-keyhole" class="h-4 w-4"></i>
                Perbarui Password
            </button>
        </form>
    </div>
</div>
@endsection
