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
            // Add slug column (unique subdomain identifier)
            $table->string('slug', 50)->unique()->after('name')->nullable();
            
            // Add status column (active, inactive, suspended)
            $table->enum('status', ['active', 'inactive', 'suspended'])
                  ->default('active')
                  ->after('is_active');
            
            // Add index for faster lookups
            $table->index('slug');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('salons', function (Blueprint $table) {
            $table->dropIndex(['slug']);
            $table->dropIndex(['status']);
            $table->dropColumn(['slug', 'status']);
        });
    }
};
