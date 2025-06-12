<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class BendaharaController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $transactions = Transaction::where('kelas_id', $user->kelas_id)->latest()->paginate(10);
        return view('bendahara.dashboard', compact('transactions'));
    }
}
