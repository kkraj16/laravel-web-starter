<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Upgrade Categories
        Schema::table('categories', function (Blueprint $table) {
            $table->text('description')->nullable()->after('name');
            $table->string('icon')->nullable()->after('description');
            $table->string('image')->nullable()->change(); // Ensure nullable
            $table->integer('position')->default(0)->after('image');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->softDeletes();
        });

        // 2. Upgrade Products
        Schema::table('products', function (Blueprint $table) {
            $table->text('short_description')->nullable()->after('name');
            $table->longText('description')->nullable()->change();
            $table->enum('product_type', ['simple', 'variable', 'digital'])->default('simple')->after('sku');
            $table->unsignedBigInteger('brand_id')->nullable()->after('product_type');
            
            // Pricing & Dates
            $table->dateTime('sale_start')->nullable()->after('sale_price');
            $table->dateTime('sale_end')->nullable()->after('sale_start');
            $table->string('tax_class')->nullable()->after('sale_end');
            
            // Inventory
            $table->boolean('manage_stock')->default(true)->after('stock_quantity');
            $table->enum('stock_status', ['instock', 'outofstock', 'onbackorder'])->default('instock')->after('stock_quantity');
            
            // Media
            $table->string('thumbnail')->nullable()->after('stock_status');
            $table->json('gallery')->nullable()->after('thumbnail');
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            
            $table->softDeletes();
        });

        // 3. Create Pivot Table
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        // 4. Migrate Data: category_id -> pivot
        $products = DB::table('products')->whereNotNull('category_id')->get();
        foreach($products as $product) {
            DB::table('product_categories')->insert([
                'product_id' => $product->id,
                'category_id' => $product->category_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 5. Drop old foreign key
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });

        // 6. Create Variants Table
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('sku')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('stock')->default(0);
            $table->json('attributes')->nullable(); // { "Color": "Red", "Size": "M" }
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Reverse operations (simplified)
        Schema::dropIfExists('product_variants');
        Schema::dropIfExists('product_categories');

        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained(); // Lossy reverse
            $table->dropSoftDeletes();
            $table->dropColumn([
                'short_description', 'product_type', 'brand_id',
                'sale_start', 'sale_end', 'tax_class',
                'manage_stock', 'stock_status', 'thumbnail', 'gallery',
                'meta_title', 'meta_description', 'meta_keywords'
            ]);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn(['icon', 'position', 'meta_title', 'meta_description', 'meta_keywords']);
        });
    }
};
