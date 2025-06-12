<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class SiswaController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $transactions = Transaction::whereHas('user', fn($q) =>
            $q->where('kelas_id', $user->kelas_id)
        )->latest()->paginate(10);

        return view('siswa.dashboard', compact('transactions'));
    }
}
