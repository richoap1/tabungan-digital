<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\User;
use App\Models\Kas;
use App\Models\VoteItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuruController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $kelas = $user->kelas_id;
        $classes = Kelas::withCount('users')->orderBy('nama_kelas')->get();
        $students = User::where('role', 'siswa')->with('kelas')->orderBy('name')->get();
        $treasurers = User::where('role', 'bendahara')->with('kelas')->orderBy('name')->get();
        $voteItems = VoteItem::where('kelas_id', $user->kelas_id)
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->withCount('votes')
            ->withCount([
                'votes as acc_votes_count' => fn ($query) => $query->where('pilihan', 'acc'),
                'votes as tidak_acc_votes_count' => fn ($query) => $query->where('pilihan', 'tidak_acc'),
            ])
            ->latest()
            ->get();

        return view('guru.dashboard', compact('kelas', 'classes', 'students', 'treasurers', 'voteItems'));
    }

    public function storeClass(Request $request)
    {
        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:255|unique:kelas,nama_kelas',
        ]);

        Kelas::create($validated);

        return back()->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function assignClass(Request $request, User $target)
    {
        /** @var \App\Models\User $teacher */
        $teacher = auth()->user();

        $validated = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        if ($target->isNot($teacher) && !in_array($target->role, ['siswa', 'bendahara'], true)) {
            abort(403, 'Guru hanya dapat mengatur kelas siswa dan bendahara.');
        }

        $target->update(['kelas_id' => $validated['kelas_id']]);

        $message = $target->is($teacher)
            ? 'Kelas Anda berhasil diperbarui.'
            : 'Kelas pengguna berhasil diperbarui.';

        return back()->with('success', $message);
    }

    public function approveVote(VoteItem $voteItem)
    {
        /** @var \App\Models\User $teacher */
        $teacher = auth()->user();

        abort_unless($teacher->kelas_id && $voteItem->kelas_id === $teacher->kelas_id, 403);

        $message = DB::transaction(function () use ($voteItem, $teacher) {
            Kelas::whereKey($teacher->kelas_id)->lockForUpdate()->firstOrFail();
            $item = VoteItem::whereKey($voteItem->id)->lockForUpdate()->firstOrFail();

            if ($item->status !== 'menunggu') {
                return 'Voting barang ini sudah diproses.';
            }

            $jumlahSuara = $item->votes()->count();
            if ($jumlahSuara === 0) {
                abort(422, 'Guru hanya dapat menyetujui barang setelah ada suara siswa.');
            }

            $saldo = (int) Kas::where('kelas_id', $item->kelas_id)
                ->whereYear('tanggal', now()->year)
                ->whereMonth('tanggal', now()->month)
                ->selectRaw("COALESCE(SUM(CASE WHEN tipe = 'pemasukan' THEN jumlah ELSE -jumlah END), 0) AS saldo")
                ->value('saldo');

            if ($saldo < $item->harga) {
                abort(422, 'Saldo kas tidak mencukupi untuk membeli barang ini.');
            }

            Kas::create([
                'user_id' => $teacher->id,
                'kelas_id' => $item->kelas_id,
                'tipe' => 'pengeluaran',
                'jumlah' => $item->harga,
                'keterangan' => 'Pembelian barang voting: '.$item->nama_item,
                'tanggal' => now()->toDateString(),
            ]);

            $item->update([
                'status' => 'disetujui',
                'disetujui_pada' => now(),
                'disetujui_oleh' => $teacher->id,
            ]);

            return 'Barang disetujui guru dan kas berhasil dikurangi.';
        });

        return back()->with('success', $message);
    }
}

