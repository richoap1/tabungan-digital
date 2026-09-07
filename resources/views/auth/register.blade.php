@extends('layouts.app')

@section('title', 'Daftar - Tabungan Digital')

@section('content')

<div class="flex min-h-screen items-center justify-center bg-slate-50 px-6 py-12">

    <div class="w-full max-w-lg">

        <div class="mb-8 text-center">

            <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-600 text-white shadow-lg shadow-indigo-200">

                <i data-lucide="wallet" class="h-7 w-7"></i>

            </div>

            <h1 class="text-3xl font-extrabold text-slate-900">
                Buat Akun
            </h1>

            <p class="mt-2 text-sm text-slate-500">
                Bergabung dengan Tabungan Digital
            </p>

        </div>


        <div class="card p-6 sm:p-8">

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
                  action="/register"
                  class="space-y-5">

                @csrf


                <div>

                    <label class="form-label">
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Masukkan nama lengkap"
                        class="form-input"
                        required
                    >

                </div>


                <div>

                    <label class="form-label">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="nama@email.com"
                        class="form-input"
                        required
                    >

                </div>


                <div class="grid gap-5 sm:grid-cols-2">

                    <div>

                        <label class="form-label">
                            Password
                        </label>

                        <input
                            type="password"
                            name="password"
                            placeholder="Minimal 6 karakter"
                            class="form-input"
                            required
                        >

                    </div>


                    <div>

                        <label class="form-label">
                            Konfirmasi Password
                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                            placeholder="Ulangi password"
                            class="form-input"
                            required
                        >

                    </div>

                </div>


                <div>

                    <label class="form-label">
                        Role
                    </label>

                    <select name="role"
                            class="form-select"
                            required>

                        <option value="">
                            Pilih Role
                        </option>

                        <option value="admin">
                            Admin
                        </option>

                        <option value="siswa">
                            Siswa
                        </option>

                        <option value="bendahara">
                            Bendahara
                        </option>

                        <option value="guru">
                            Guru
                        </option>

                    </select>

                </div>


                <button type="submit"
                        class="btn-primary w-full">

                    <i data-lucide="user-plus" class="h-5 w-5"></i>

                    Buat Akun

                </button>

            </form>

        </div>


        <p class="mt-6 text-center text-sm text-slate-500">

            Sudah mempunyai akun?

            <a href="/login"
               class="font-bold text-indigo-600">

                Masuk

            </a>

        </p>

    </div>

</div>

@endsection