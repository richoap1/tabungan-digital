<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vote_items', function (Blueprint $table) {
            $table->unsignedBigInteger('harga')->after('deskripsi');
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak'])
                ->default('menunggu')
                ->after('aktif_hingga');
            $table->timestamp('disetujui_pada')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('vote_items', function (Blueprint $table) {
            $table->dropColumn(['harga', 'status', 'disetujui_pada']);
        });
    }
};
