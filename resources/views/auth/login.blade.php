@extends('layouts.app')

@section('title', 'Masuk - Tabungan Digital')

@section('content')

<div class="flex min-h-screen bg-slate-50">

    <!-- LEFT -->

    <div class="relative hidden overflow-hidden bg-indigo-600 lg:flex lg:w-1/2">

        <div class="absolute -right-20 -top-20 h-72 w-72 rounded-full bg-white/10"></div>
        <div class="absolute -bottom-32 -left-20 h-96 w-96 rounded-full bg-white/10"></div>

        <div class="relative z-10 flex flex-col justify-between p-16 text-white">

            <div class="flex items-center gap-3">

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/15 backdrop-blur">

                    <i data-lucide="wallet" class="h-6 w-6"></i>

                </div>

                <div>

                    <p class="font-extrabold">
                        Tabungan Digital
                    </p>

                    <p class="text-xs text-indigo-200">
                        Smart Class Finance
                    </p>

                </div>

            </div>


            <div class="max-w-lg">

                <p class="mb-4 text-sm font-semibold text-indigo-200">
                    KELOLA TABUNGAN KELAS
                </p>

                <h1 class="text-5xl font-extrabold leading-tight">
                    Menabung lebih mudah,
                    <span class="text-indigo-200">
                        transparan & modern.
                    </span>
                </h1>

                <p class="mt-6 leading-7 text-indigo-100">
                    Kelola transaksi tabungan kelas, pantau aktivitas,
                    dan ikuti voting barang dalam satu platform.
                </p>

            </div>


            <p class="text-sm text-indigo-200">
                © {{ date('Y') }} Tabungan Digital
            </p>

        </div>

    </div>


    <!-- RIGHT -->

    <div class="flex w-full items-center justify-center px-6 py-12 lg:w-1/2">

        <div class="w-full max-w-md">

            <div class="mb-8 lg:hidden">

                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-600 text-white">

                    <i data-lucide="wallet"></i>

                </div>

                <h1 class="text-2xl font-extrabold">
                    Tabungan Digital
                </h1>

            </div>


            <div class="mb-8">

                <p class="mb-2 text-sm font-semibold text-indigo-600">
                    SELAMAT DATANG KEMBALI
                </p>

                <h2 class="text-3xl font-extrabold tracking-tight text-slate-900">
                    Masuk ke akun Anda
                </h2>

                <p class="mt-2 text-sm text-slate-500">
                    Silakan masukkan data akun untuk melanjutkan.
                </p>

            </div>


            @if($errors->any())

                <div class="alert alert-error">

                    <i data-lucide="alert-circle" class="h-5 w-5"></i>

                    <div>

                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach

                    </div>

                </div>

            @endif


            <form method="POST"
                  action="/login"
                  class="space-y-5">

                @csrf


                <div>

                    <label class="form-label">
                        Email
                    </label>

                    <div class="relative">

                        <i data-lucide="mail"
                           class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400">
                        </i>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="nama@email.com"
                            class="form-input pl-12"
                            required
                            autofocus
                        >

                    </div>

                </div>


                <div>

                    <div class="mb-2 flex justify-between">

                        <label class="form-label mb-0">
                            Password
                        </label>

                    </div>

                    <div class="relative">

                        <i data-lucide="lock"
                           class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400">
                        </i>

                        <input
                            type="password"
                            name="password"
                            placeholder="Masukkan password"
                            class="form-input pl-12"
                            required
                        >

                    </div>

                </div>


                <button type="submit"
                        class="btn-primary w-full py-3.5">

                    <i data-lucide="log-in" class="h-5 w-5"></i>

                    Masuk

                </button>

            </form>


            <div class="mt-8 text-center text-sm text-slate-500">

                Belum mempunyai akun?

                <a href="/register"
                   class="font-bold text-indigo-600 hover:text-indigo-700">

                    Daftar sekarang

                </a>

            </div>

        </div>

    </div>

</div>

@endsection