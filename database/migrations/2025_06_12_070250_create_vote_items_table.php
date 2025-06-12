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
        Schema::create('vote_items', function (Blueprint $table) {
        $table->id();
        $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
        $table->foreignId('periode_id')->constrained('periodes')->onDelete('cascade');
        $table->string('nama_item');
        $table->text('deskripsi');
        $table->date('aktif_hingga');
        $table->foreignId('dibuat_oleh')->constrained('users')->onDelete('cascade'); // bendahara
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vote_items');
    }
};
