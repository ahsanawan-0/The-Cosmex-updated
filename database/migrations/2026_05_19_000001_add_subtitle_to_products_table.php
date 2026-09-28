<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Production already has this column (added before this migration was
        // recorded), so only add it where it is missing.
        if (Schema::hasColumn('products', 'subtitle')) {
            return;
        }

        Schema::table('products', function (Blueprint $table) {
            $table->string('subtitle')->nullable()->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('subtitle');
        });
    }
};
