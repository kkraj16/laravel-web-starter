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
        Schema::table('products', function (Blueprint $table) {
            $table->string('material')->nullable()->after('description');
            $table->string('purity')->nullable()->after('material');
            $table->decimal('weight', 8, 2)->nullable()->after('purity');
            $table->boolean('is_trending')->default(false)->after('is_active');
            $table->boolean('show_on_homepage')->default(false)->after('is_trending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['material', 'purity', 'weight', 'is_trending', 'show_on_homepage']);
        });
    }
};
