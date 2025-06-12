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
            ->where('aktif_hingga', '>=', now())
            ->get();

        return view('siswa.vote.index', compact('voteItems'));
    }

    public function store(Request $request, VoteItem $vote_item)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $exists = Vote::where('user_id', $user->id)
            ->where('vote_item_id', $vote_item->id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Kamu sudah memberikan suara.');
        }

        Vote::create([
            'user_id' => $user->id,
            'vote_item_id' => $vote_item->id
        ]);

        return back()->with('success', 'Voting berhasil.');
    }
}
