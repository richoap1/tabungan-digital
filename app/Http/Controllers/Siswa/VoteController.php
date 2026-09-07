<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Vote;
use App\Models\VoteItem;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $voteItems = VoteItem::where('kelas_id', $user->kelas_id)
            ->where('status', 'menunggu')
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->whereDate('aktif_hingga', '>=', today())
            ->withCount([
                'votes as acc_votes_count' => fn ($query) => $query->where('pilihan', 'acc'),
                'votes as tidak_acc_votes_count' => fn ($query) => $query->where('pilihan', 'tidak_acc'),
            ])
            ->with(['votes' => fn ($query) => $query->where('user_id', $user->id)])
            ->get();

        return view('siswa.vote.index', compact('voteItems'));
    }

    public function store(Request $request, VoteItem $vote_item)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $validated = $request->validate([
            'pilihan' => 'required|in:acc,tidak_acc',
        ]);

        abort_unless($vote_item->kelas_id === $user->kelas_id, 403);

        if ($vote_item->status !== 'menunggu' || $vote_item->aktif_hingga->isBefore(today())) {
            return back()->with('error', 'Voting barang ini sudah tidak aktif.');
        }

        $vote = Vote::where('user_id', $user->id)
            ->where('vote_item_id', $vote_item->id)
            ->first();

        if ($vote) {
            return back()->with('error', 'Kamu sudah memberikan suara untuk barang ini.');
        }

        Vote::create([
            'user_id' => $user->id,
            'vote_item_id' => $vote_item->id,
            'pilihan' => $validated['pilihan'],
        ]);

        return back()->with('success', 'Pilihan voting berhasil disimpan.');
    }
}
