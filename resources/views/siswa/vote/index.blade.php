@extends('layouts.app')

@section('title', 'Voting Barang')

@section('content')
<h2 class="text-xl font-bold mb-4">Voting Barang</h2>

@foreach ($voteItems as $item)
    <div class="p-4 border mb-4 rounded bg-white">
        <h3 class="text-lg font-semibold">{{ $item->nama_item }}</h3>
        <p class="text-sm text-gray-600">{{ $item->deskripsi }}</p>
        <p class="text-xs text-gray-500">Berlaku hingga: {{ $item->aktif_hingga }}</p>

        <form method="POST" action="{{ route('vote.store', $item->id) }}" class="mt-2">
            @csrf
            <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded">Vote</button>
        </form>
    </div>
@endforeach
@endsection
