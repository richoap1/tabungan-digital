<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $kelas = $user->kelas_id;

        return view('guru.dashboard', compact('kelas'));
    }
}

