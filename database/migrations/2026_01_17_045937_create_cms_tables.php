<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable(); // From upgrade
            $table->string('slug')->unique();
            $table->string('icon')->nullable(); // From upgrade
            $table->foreignId('parent_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->string('image')->nullable();
            $table->integer('position')->default(0); // From upgrade
            $table->boolean('is_active')->default(true);
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('category_id')... Removed in favor of pivot
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable(); // From upgrade
            $table->longText('description')->nullable(); // Changed to longText
            
            $table->enum('product_type', ['simple', 'variable', 'digital'])->default('simple'); // From upgrade
            $table->unsignedBigInteger('brand_id')->nullable(); // From upgrade
            
            $table->decimal('price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();
            
            // Pricing & Dates
            $table->dateTime('sale_start')->nullable();
            $table->dateTime('sale_end')->nullable();
            $table->string('tax_class')->nullable();

            $table->string('sku')->unique()->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->boolean('manage_stock')->default(true); // From upgrade
            $table->enum('stock_status', ['instock', 'outofstock', 'onbackorder'])->default('instock'); // From upgrade
            
            // Custom Details (From add_details migration)
            $table->string('material')->nullable();
            $table->string('purity')->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            
            $table->boolean('is_active')->default(true);
            $table->boolean('is_trending')->default(false); // From add_details
            $table->boolean('show_on_homepage')->default(false); // From add_details
            
            // Media
            $table->string('thumbnail')->nullable(); // From upgrade
            $table->json('gallery')->nullable(); // From upgrade
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('image_path');
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });

        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Registered user
            $table->string('customer_name')->nullable(); // Guest user name
            $table->integer('rating'); // 1-5
            $table->text('comment')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
        });
        
        // Pivot Table (From upgrade)
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        // Variants Table (From upgrade)
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
        Schema::dropIfExists('product_variants');
        Schema::dropIfExists('product_categories');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
    }
};
