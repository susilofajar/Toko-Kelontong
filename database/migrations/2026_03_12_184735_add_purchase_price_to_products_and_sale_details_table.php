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
        if (!Schema::hasColumn('sale_details', 'purchase_price')) {
            Schema::table('sale_details', function (Blueprint $table) {
                $table->decimal('purchase_price', 15, 2)->after('unit_price')->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('sale_details', 'purchase_price')) {
            Schema::table('sale_details', function (Blueprint $table) {
                $table->dropColumn('purchase_price');
            });
        }
    }
};
