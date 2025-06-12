@extends('layouts.app')

@section('title', 'Login')

@section('content')
<h2 class="text-xl mb-4">Login</h2>
<form method="POST" action="/login" class="space-y-4">
    @csrf
    <input type="email" name="email" placeholder="Email" class="w-full p-2 border" required>
    <input type="password" name="password" placeholder="Password" class="w-full p-2 border" required>
    <button type="submit" class="bg-blue-600 text-white px-4 py-2">Login</button>
</form>
@endsection
