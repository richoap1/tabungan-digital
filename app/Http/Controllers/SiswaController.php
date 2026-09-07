<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kas;
use App\Models\VoteItem;

class SiswaController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $transactions = Kas::where('siswa_id', $user->id)
            ->latest('tanggal')
            ->latest()
            ->paginate(10);

        $totalKas = (int) Kas::where('siswa_id', $user->id)
            ->selectRaw("COALESCE(SUM(CASE WHEN tipe = 'pemasukan' THEN jumlah ELSE -jumlah END), 0) AS saldo")
            ->value('saldo');

        $voteItems = VoteItem::where('kelas_id', $user->kelas_id)
            ->where('status', 'menunggu')
            ->whereDate('aktif_hingga', '>=', today())
            ->withCount([
                'votes as acc_votes_count' => fn ($query) => $query->where('pilihan', 'acc'),
                'votes as tidak_acc_votes_count' => fn ($query) => $query->where('pilihan', 'tidak_acc'),
            ])
            ->with(['votes' => fn ($query) => $query->where('user_id', $user->id)])
            ->latest()
            ->get();

        return view('siswa.dashboard', compact('transactions', 'totalKas', 'voteItems'));
    }
}
