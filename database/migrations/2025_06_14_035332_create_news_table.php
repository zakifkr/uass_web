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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('featured_image')->nullable();
            $table->json('gallery')->nullable(); // Multiple images
            
            // Relations
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            
            // Status & Publishing
            $table->enum('status', ['draft', 'pending', 'approved', 'rejected', 'published'])->default('draft');
            $table->timestamp('published_at')->nullable();
            
            // SEO Fields
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            
            // Stats
            $table->integer('views_count')->default(0);
            $table->boolean('is_featured')->default(false);
            
            $table->timestamps();
            
            // Indexes
            $table->index(['status', 'published_at']);
            $table->index(['author_id', 'status']);
            $table->index('category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};