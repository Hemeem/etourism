<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            // Menambahkan kolom teks panjang (bisa menampung enter/baris baru)
            $table->text('includes')->nullable();
            $table->text('excludes')->nullable();
            $table->text('itinerary')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn(['includes', 'excludes', 'itinerary']);
        });
    }
};