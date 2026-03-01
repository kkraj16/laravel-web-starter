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
        Schema::create('seo_metas', function (Blueprint $table) {
            $table->id();
            // Polymorphic relation to handle Product/Category SEO
            $table->nullableMorphs('seoable');
            
            // For static pages (Home, About, Contact)
            $table->string('page_path')->nullable()->index();
            $table->string('route_name')->nullable()->index();
            
            // Core SEO fields
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('canonical_url')->nullable();
            
            // Open Graph tags
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image')->nullable();
            
            // Search Engine Directives
            $table->string('robots')->default('index, follow'); // index, noindex, follow, nofollow
            
            // Custom Structured Data (JSON-LD)
            $table->json('structured_data')->nullable(); // Changed to text for compatibility if JSON column not supported but mostly fine
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_metas');
    }
};
