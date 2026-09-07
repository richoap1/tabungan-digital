@extends('layouts.app')

@section('title', 'Profil')
@section('breadcrumb', 'Akun / Profil')
@section('header', 'Profil')

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
        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-100 text-xl font-extrabold text-indigo-600">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
        <h1 class="mt-4 text-2xl font-extrabold text-slate-900">Profil Saya</h1>
        <p class="mt-1 text-sm text-slate-500">Kelola informasi akun yang tampil di aplikasi.</p>
    </div>

    <div class="card p-6">
        <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
            @csrf
            @method('PATCH')
            <div>
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="form-input" required>
            </div>
            <div>
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="form-input" required>
            </div>
            <div>
                <label class="form-label">Role</label>
                <input type="text" value="{{ ucfirst(auth()->user()->role) }}" class="form-input bg-slate-50" disabled>
            </div>
            <button type="submit" class="btn-primary">
                <i data-lucide="save" class="h-4 w-4"></i>
                Simpan Profil
            </button>
        </form>
    </div>
</div>
@endsection
