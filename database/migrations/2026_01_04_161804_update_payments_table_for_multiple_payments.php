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
        // Payments table already supports multiple payments per order
        // Just ensure method column can handle enum values properly
        // Note: We'll keep it as string for flexibility, but add validation in model
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No changes needed to reverse
    }
};
