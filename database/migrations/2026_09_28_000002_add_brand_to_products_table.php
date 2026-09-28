<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('products', 'brand')) {
            Schema::table('products', function (Blueprint $table) {
                // Manufacturer brand for Product structured data (never the seller).
                $table->string('brand', 100)->nullable()->after('subtitle');
            });
        }
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('brand');
        });
    }
};
