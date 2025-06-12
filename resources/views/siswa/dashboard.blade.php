@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<h2 class="text-xl font-bold mb-4">Dashboard Siswa</h2>
<p>Selamat datang, {{ auth()->user()->name }} (Siswa)</p>

<h3 class="text-lg font-semibold mt-6">Riwayat Transaksi</h3>
<table class="w-full table-auto border mt-2">
    <thead>
        <tr class="bg-gray-200">
            <th class="p-2 border">Tanggal</th>
            <th class="p-2 border">Tipe</th>
            <th class="p-2 border">Jumlah</th>
            <th class="p-2 border">Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transactions as $trans)
        <tr>
            <td class="p-2 border">{{ $trans->tanggal }}</td>
            <td class="p-2 border">{{ ucfirst($trans->tipe) }}</td>
            <td class="p-2 border">Rp {{ number_format($trans->jumlah, 0, ',', '.') }}</td>
            <td class="p-2 border">{{ $trans->keterangan }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-4">
    {{ $transactions->links() }}
</div>
@endsection
