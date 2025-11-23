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
            $table->string('cover_image')->nullable()->after('image');
            $table->string('logo')->nullable()->after('cover_image');
            $table->text('full_description')->nullable()->after('description');
            $table->string('facebook')->nullable()->after('email');
            $table->string('instagram')->nullable()->after('facebook');
            $table->string('twitter')->nullable()->after('instagram');
            $table->string('linkedin')->nullable()->after('twitter');
            $table->string('youtube')->nullable()->after('linkedin');
            $table->string('website')->nullable()->after('youtube');
            $table->integer('followers_count')->default(0)->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('salons', function (Blueprint $table) {
            $table->dropColumn([
                'cover_image',
                'logo',
                'full_description',
                'facebook',
                'instagram',
                'twitter',
                'linkedin',
                'youtube',
                'website',
                'followers_count'
            ]);
        });
    }
};
