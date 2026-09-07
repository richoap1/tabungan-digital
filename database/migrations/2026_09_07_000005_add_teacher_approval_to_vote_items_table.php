<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vote_items', function (Blueprint $table) {
            $table->foreignId('disetujui_oleh')
                ->nullable()
                ->after('disetujui_pada')
                ->constrained('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('vote_items', function (Blueprint $table) {
            $table->dropForeign(['disetujui_oleh']);
            $table->dropColumn('disetujui_oleh');
        });
    }
};
