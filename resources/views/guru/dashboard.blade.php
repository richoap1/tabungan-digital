@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('content')
<h2 class="text-xl font-bold mb-4">Dashboard Guru</h2>
<p>Selamat datang, {{ auth()->user()->name }} (Guru)</p>

<p class="mt-4">Anda tergabung dalam kelas ID: <strong>{{ $kelas }}</strong></p>
@endsection
