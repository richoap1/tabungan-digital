@extends('layouts.app')

@section('title', 'Voting Barang')

@section('breadcrumb', 'Siswa / Voting')

@section('header', 'Voting Barang')

@section('content')

<div class="mb-8">

    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">

        <div>

            <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600">

                <i data-lucide="vote" class="h-6 w-6"></i>

            </div>

            <h1 class="text-2xl font-extrabold text-slate-900">
                Voting Barang
            </h1>

            <p class="mt-2 max-w-xl text-sm leading-6 text-slate-500">
                Pilih barang yang ingin dibeli menggunakan
                tabungan kelas. Setiap pilihanmu membantu menentukan
                kebutuhan kelas.
            </p>

        </div>

        <a href="{{ route('siswa.dashboard') }}"
           class="btn-secondary">

            <i data-lucide="arrow-left" class="h-4 w-4"></i>

            Kembali

        </a>

    </div>

</div>


@if($voteItems->count())

    <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">

        @foreach ($voteItems as $item)

            <div class="card group overflow-hidden transition duration-300 hover:-translate-y-1 hover:shadow-xl">

                <!-- Illustration -->

                <div class="relative flex h-40 items-center justify-center overflow-hidden bg-gradient-to-br from-indigo-50 to-violet-50">

                    @if($item->gambar)
                        <img src="{{ asset('storage/'.$item->gambar) }}" alt="{{ $item->nama_item }}" class="h-full w-full object-cover">
                    @else
                        <div class="flex h-20 w-20 items-center justify-center rounded-3xl bg-white text-indigo-600 shadow-lg shadow-indigo-100 transition duration-300 group-hover:scale-110">
                            <i data-lucide="shopping-bag" class="h-9 w-9"></i>
                        </div>
                    @endif

                    <span class="absolute right-4 top-4 badge badge-success">

                        <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                        Aktif

                    </span>

                </div>


                <!-- Content -->

                <div class="p-6">

                    <h2 class="text-lg font-extrabold text-slate-900">

                        {{ $item->nama_item }}

                    </h2>

                    <p class="mt-2 min-h-[48px] text-sm leading-6 text-slate-500">

                        {{ $item->deskripsi }}

                    </p>

                    <p class="mt-3 text-sm font-bold text-slate-700">
                        Harga: Rp {{ number_format($item->harga, 0, ',', '.') }}
                    </p>

                    <div class="mt-4 grid grid-cols-2 gap-2 text-center text-xs">
                        <div class="rounded-lg bg-emerald-50 px-3 py-2 text-emerald-700">
                            <span class="block font-extrabold">{{ $item->acc_votes_count }}</span>
                            ACC
                        </div>
                        <div class="rounded-lg bg-rose-50 px-3 py-2 text-rose-700">
                            <span class="block font-extrabold">{{ $item->tidak_acc_votes_count }}</span>
                            Tidak ACC
                        </div>
                    </div>


                    <div class="my-5 border-t border-slate-100"></div>


                    <div class="mb-5 flex items-center gap-3">

                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-100 text-slate-500">

                            <i data-lucide="calendar-clock" class="h-4 w-4"></i>

                        </div>

                        <div>

                            <p class="text-xs text-slate-400">
                                Berlaku hingga
                            </p>

                            <p class="text-sm font-bold text-slate-700">
                                {{ $item->aktif_hingga }}
                            </p>

                        </div>

                    </div>


                    @php($currentVote = $item->votes->first())

                    <p class="mb-3 text-xs text-slate-400">
                        Pilihan Anda: {{ $currentVote ? ($currentVote->pilihan === 'acc' ? 'ACC' : 'Tidak ACC') : 'Belum memilih' }}
                    </p>

                    <form method="POST" action="{{ route('vote.store', $item->id) }}" class="grid grid-cols-2 gap-2">

                        @csrf

                        <button type="submit" name="pilihan" value="acc" class="btn-primary disabled:cursor-not-allowed disabled:opacity-50" @disabled($currentVote)>

                            <i data-lucide="check-circle" class="h-4 w-4"></i>

                            ACC
                        </button>

                        <button type="submit" name="pilihan" value="tidak_acc" class="btn-secondary disabled:cursor-not-allowed disabled:opacity-50" @disabled($currentVote)>
                            <i data-lucide="x-circle" class="h-4 w-4"></i>
                            Tidak ACC

                        </button>

                    </form>

                </div>

            </div>

        @endforeach

    </div>

@else

    <div class="card py-16 text-center">

        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-slate-100">

            <i data-lucide="vote" class="h-7 w-7 text-slate-400"></i>

        </div>

        <h3 class="mt-5 text-lg font-bold text-slate-700">
            Belum ada voting
        </h3>

        <p class="mx-auto mt-2 max-w-md text-sm text-slate-400">
            Saat ini belum terdapat barang yang dapat dipilih.
            Silakan kembali lagi nanti.
        </p>

    </div>

@endif

@endsection