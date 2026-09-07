<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kas;
use App\Models\User;
use App\Models\VoteItem;

class BendaharaController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $kas = Kas::where('kelas_id', $user->kelas_id)
            ->with('siswa')
            ->whereYear('tanggal', now()->year)
            ->whereMonth('tanggal', now()->month)
            ->latest('tanggal')
            ->latest()
            ->paginate(10, ['*'], 'kas_page');
        $voteItems = VoteItem::where('kelas_id', $user->kelas_id)
            ->withCount([
                'votes as acc_votes_count' => fn ($query) => $query->where('pilihan', 'acc'),
                'votes as tidak_acc_votes_count' => fn ($query) => $query->where('pilihan', 'tidak_acc'),
            ])
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->latest()
            ->get();
        $siswas = User::where('kelas_id', $user->kelas_id)
            ->where('role', 'siswa')
            ->orderBy('name')
            ->get(['id', 'name', 'email']);
        $saldoKas = (int) Kas::where('kelas_id', $user->kelas_id)
            ->whereYear('tanggal', now()->year)
            ->whereMonth('tanggal', now()->month)
            ->selectRaw("COALESCE(SUM(CASE WHEN tipe = 'pemasukan' THEN jumlah ELSE -jumlah END), 0) AS saldo")
            ->value('saldo');

        return view('bendahara.dashboard', compact(
            'kas',
            'voteItems',
            'siswas',
            'saldoKas'
        ));
    }

    public function transactions()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $kas = $this->monthlyKas($user->kelas_id);
        $siswas = User::where('kelas_id', $user->kelas_id)
            ->where('role', 'siswa')
            ->orderBy('name')
            ->get(['id', 'name', 'email']);
        $saldoKas = $this->monthlyBalance($user->kelas_id);

        return view('bendahara.transactions', compact('kas', 'siswas', 'saldoKas'));
    }

    public function voting()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $voteItems = VoteItem::where('kelas_id', $user->kelas_id)
            ->withCount([
                'votes as acc_votes_count' => fn ($query) => $query->where('pilihan', 'acc'),
                'votes as tidak_acc_votes_count' => fn ($query) => $query->where('pilihan', 'tidak_acc'),
            ])
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->latest()
            ->get();

        return view('bendahara.voting', compact('voteItems'));
    }

    private function monthlyKas(?int $kelasId)
    {
        return Kas::where('kelas_id', $kelasId)
            ->with('siswa')
            ->whereYear('tanggal', now()->year)
            ->whereMonth('tanggal', now()->month)
            ->latest('tanggal')
            ->latest()
            ->paginate(15);
    }

    private function monthlyBalance(?int $kelasId): int
    {
        return (int) Kas::where('kelas_id', $kelasId)
            ->whereYear('tanggal', now()->year)
            ->whereMonth('tanggal', now()->month)
            ->selectRaw("COALESCE(SUM(CASE WHEN tipe = 'pemasukan' THEN jumlah ELSE -jumlah END), 0) AS saldo")
            ->value('saldo');
    }
}
