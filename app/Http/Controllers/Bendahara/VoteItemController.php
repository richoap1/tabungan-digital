<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\VoteItem;
use Illuminate\Http\Request;

class VoteItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return redirect()->route('bendahara.dashboard');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('bendahara.dashboard');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $validated = $request->validate([
            'nama_item' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'harga' => 'required|integer|min:1',
            'aktif_hingga' => 'required|date|after_or_equal:today',
        ]);

        if (!$user->kelas_id) {
            return back()->withErrors(['kelas_id' => 'Akun bendahara belum memiliki kelas.']);
        }

        $data = collect($validated)->except('gambar')->all();

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('vote-items', 'public');
        }

        VoteItem::create([
            ...$data,
            'kelas_id' => $user->kelas_id,
            'dibuat_oleh' => $user->id,
        ]);

        return back()->with('success', 'Voting barang berhasil dibuat.');
    }

    public function reject(VoteItem $voteItem)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        abort_unless($voteItem->kelas_id === $user->kelas_id, 403);

        if ($voteItem->status !== 'menunggu') {
            return back()->with('error', 'Voting barang ini sudah diproses.');
        }

        $voteItem->update(['status' => 'ditolak']);

        return back()->with('success', 'Barang ditolak.');
    }
}
