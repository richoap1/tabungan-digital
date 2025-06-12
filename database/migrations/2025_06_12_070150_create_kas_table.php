<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // siapa yang input
        $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
        $table->foreignId('periode_id')->constrained('periodes')->onDelete('cascade');
        $table->enum('tipe', ['pemasukan', 'pengeluaran']);
        $table->integer('jumlah');
        $table->string('keterangan')->nullable();
        $table->date('tanggal');
        $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kas');
    }
};
