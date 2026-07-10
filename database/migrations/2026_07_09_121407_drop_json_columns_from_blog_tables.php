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
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropColumn(['title', 'summary', 'content']);
        });

        Schema::table('blog_categories', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->json('title')->nullable();
            $table->json('summary')->nullable();
            $table->json('content')->nullable();
        });

        Schema::table('blog_categories', function (Blueprint $table) {
            $table->json('name')->nullable();
        });
    }
};
