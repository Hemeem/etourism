<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('filter_category', ['Destinasi', 'Kuliner', 'Tips Liburan', 'Budaya']);
            $table->binary('image'); // Menyimpan data biner gambar (BLOB)
            $table->string('source')->default('Internal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};