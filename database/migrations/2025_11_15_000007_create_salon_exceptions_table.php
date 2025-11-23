<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('salon_exceptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('salon_id')->constrained('salons')->onDelete('cascade');
            $table->date('date');
            $table->boolean('is_off')->default(true)->comment('Holiday, special event');
            $table->string('reason')->nullable();
            $table->timestamps();
            
            $table->index(['salon_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salon_exceptions');
    }
};
