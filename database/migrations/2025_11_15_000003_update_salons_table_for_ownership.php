<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('salons', function (Blueprint $table) {
            $table->foreignId('owner_id')->after('id')->nullable()->constrained('users')->onDelete('cascade');
            $table->time('default_open_time')->default('09:00:00')->after('opening_time');
            $table->time('default_close_time')->default('18:00:00')->after('closing_time');
            $table->json('off_days')->nullable()->after('working_days')->comment('Days salon is closed, e.g. [5] for Friday');
            $table->decimal('commission_percentage', 5, 2)->default(30.00)->after('is_active')->comment('Salon commission %');
        });
    }

    public function down(): void
    {
        Schema::table('salons', function (Blueprint $table) {
            $table->dropForeign(['owner_id']);
            $table->dropColumn(['owner_id', 'default_open_time', 'default_close_time', 'off_days', 'commission_percentage']);
        });
    }
};
