<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kas', function (Blueprint $table) {
            $table->foreignId('periode_id')->nullable()->change();
        });

        Schema::table('vote_items', function (Blueprint $table) {
            $table->foreignId('periode_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('kas', function (Blueprint $table) {
            $table->foreignId('periode_id')->nullable(false)->change();
        });

        Schema::table('vote_items', function (Blueprint $table) {
            $table->foreignId('periode_id')->nullable(false)->change();
        });
    }
};
