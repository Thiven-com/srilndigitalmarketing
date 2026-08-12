<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('package_levels', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('package_id')->nullable();

            // Level number: 1, 2, 3, 4, 5, 6
            $table->unsignedTinyInteger('level')->nullable();

            // Example: Level 1, Level 2...
            $table->string('name')->nullable();

            // fixed / percentage
            $table->string('calculation_type')->default('fixed')->nullable();

            // Used when calculation_type = fixed
            $table->decimal('amount', 12, 2)->nullable();

            // Used when calculation_type = percentage
            $table->decimal('percentage', 8, 2)->nullable();

            // Optional qualification requirement
            $table->decimal('minimum_business', 12, 2)->nullable();

            // Optional maximum income for this level
            $table->decimal('maximum_income', 12, 2)->nullable();

            $table->text('description')->nullable();

            $table->unsignedInteger('sort_order')->default(0)->nullable();

            $table->boolean('status')->default(true)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_levels');
    }
};