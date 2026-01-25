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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('text_alignment')->default('center'); // Added
            $table->string('content_position')->default('center'); // Added
            $table->string('image_path');
            $table->string('mobile_image_path')->nullable(); // Added
            $table->string('content_image_path')->nullable(); // Added
            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();
            $table->integer('sort_order')->default(0); // Renamed from order
            $table->boolean('is_active')->default(true);
            $table->boolean('show_content')->default(true); // Added
            $table->boolean('show_content_image')->default(true); // Added
            $table->decimal('overlay_opacity', 3, 1)->default(0.6); // Added
            $table->boolean('animate_image')->default(true); // Added
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
