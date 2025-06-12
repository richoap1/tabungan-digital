@extends('layouts.app')

@section('title', 'Register')

@section('content')
<h2 class="text-xl mb-4">Register</h2>
<form method="POST" action="/register" class="space-y-4">
    @csrf
    <input type="text" name="name" placeholder="Nama" class="w-full p-2 border" required>
    <input type="email" name="email" placeholder="Email" class="w-full p-2 border" required>
    <input type="password" name="password" placeholder="Password" class="w-full p-2 border" required>
    <input type="password" name="password_confirmation" placeholder="Ulangi Password" class="w-full p-2 border" required>

    <select name="role" class="w-full p-2 border" required>
        <option value="">Pilih Role</option>
        <option value="siswa">Siswa</option>
        <option value="bendahara">Bendahara</option>
        <option value="guru">Guru</option>
    </select>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2">Register</button>
</form>
@endsection
