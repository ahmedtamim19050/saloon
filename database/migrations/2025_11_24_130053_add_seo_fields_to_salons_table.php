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
        Schema::table('salons', function (Blueprint $table) {
            $table->string('seo_title')->nullable()->after('full_description');
            $table->text('seo_description')->nullable()->after('seo_title');
            $table->json('keywords')->nullable()->after('seo_description');
            $table->json('tags')->nullable()->after('keywords');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('salons', function (Blueprint $table) {
            $table->dropColumn(['seo_title', 'seo_description', 'keywords', 'tags']);
        });
    }
};
