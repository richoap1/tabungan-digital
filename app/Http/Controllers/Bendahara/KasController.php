<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\Kas;
use App\Models\Kelas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KasController extends Controller
{
    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $validated = $request->validate([
            'tipe' => 'required|in:pemasukan,pengeluaran',
            'siswa_id' => 'nullable|exists:users,id|required_if:tipe,pemasukan',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string|max:255',
            'tanggal' => 'required|date',
        ]);

        if (!$user->kelas_id) {
            return back()->withErrors(['kelas_id' => 'Akun bendahara belum memiliki kelas.']);
        }

        if (!empty($validated['siswa_id']) && !\App\Models\User::whereKey($validated['siswa_id'])
            ->where('kelas_id', $user->kelas_id)
            ->where('role', 'siswa')
            ->exists()) {
            return back()->withErrors(['siswa_id' => 'Siswa tidak terdaftar di kelas bendahara.'])->withInput();
        }

        if ($validated['tipe'] === 'pengeluaran') {
            $balance = $this->balance($user->kelas_id, $validated['tanggal']);

            if ($validated['jumlah'] > $balance) {
                return back()->withErrors([
                    'jumlah' => 'Saldo kas tidak mencukupi untuk pengeluaran ini.',
                ])->withInput();
            }
        }

        DB::transaction(function () use ($validated, $user) {
            Kelas::whereKey($user->kelas_id)->lockForUpdate()->firstOrFail();

            if ($validated['tipe'] === 'pengeluaran') {
                $balance = $this->balance($user->kelas_id, $validated['tanggal']);

                if ($validated['jumlah'] > $balance) {
                    abort(422, 'Saldo kas tidak mencukupi untuk pengeluaran ini.');
                }
            }

            Kas::create([
                'user_id' => $user->id,
                'siswa_id' => $validated['siswa_id'] ?? null,
                'kelas_id' => $user->kelas_id,
                'tipe' => $validated['tipe'],
                'jumlah' => $validated['jumlah'],
                'keterangan' => $validated['keterangan'] ?? null,
                'tanggal' => $validated['tanggal'],
            ]);
        });

        return back()->with('success', 'Kas berhasil dicatat.');
    }

    private function balance(int $kelasId, string $date): int
    {
        $month = Carbon::parse($date);

        return (int) Kas::where('kelas_id', $kelasId)
            ->whereYear('tanggal', $month->year)
            ->whereMonth('tanggal', $month->month)
            ->selectRaw("COALESCE(SUM(CASE WHEN tipe = 'pemasukan' THEN jumlah ELSE -jumlah END), 0) AS saldo")
            ->value('saldo');
    }
}
