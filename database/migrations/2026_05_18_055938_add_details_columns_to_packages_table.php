<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            if (!Schema::hasColumn('packages', 'slug')) {
                $table->string('slug')->nullable()->after('title');
            }
            if (!Schema::hasColumn('packages', 'duration')) {
                $table->string('duration')->nullable()->after('category');
            }
            if (!Schema::hasColumn('packages', 'min_pax')) {
                $table->integer('min_pax')->default(2)->after('duration');
            }
            if (!Schema::hasColumn('packages', 'includes')) {
                $table->text('includes')->nullable();
            }
            if (!Schema::hasColumn('packages', 'excludes')) {
                $table->text('excludes')->nullable();
            }
            if (!Schema::hasColumn('packages', 'itinerary')) {
                $table->text('itinerary')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            // Drop kolom secara aman jika ada saat rollback
            $columns = ['slug', 'duration', 'min_pax', 'includes', 'excludes', 'itinerary'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('packages', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};