<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            if (!Schema::hasColumn('services', 'category_id')) {
                $table->foreignId('category_id')->nullable()->after('id')->constrained('service_categories')->onDelete('set null');
            }
            if (!Schema::hasColumn('services', 'pricing_tier')) {
                $table->string('pricing_tier')->default('regular')->after('price');
            }
            if (!Schema::hasColumn('services', 'duration_minutes')) {
                $table->unsignedInteger('duration_minutes')->nullable()->after('pricing_tier');
            }
            if (!Schema::hasColumn('services', 'is_available')) {
                $table->boolean('is_available')->default(true)->after('duration_minutes');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn(['category_id', 'pricing_tier', 'duration_minutes', 'is_available']);
        });
    }
};
