<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();

            // Basic package information
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('code')->nullable();

            // Package amount
            $table->decimal('price', 12, 2)->default(0)->nullable();

            // Optional joining / renewal amount
            $table->decimal('joining_amount', 12, 2)->default(0);
            $table->decimal('renewal_amount', 12, 2)->default(0);

            // Website content
            $table->string('short_description')->nullable();
            $table->longText('description')->nullable();

            // Media
            $table->string('image')->nullable();
            $table->string('icon')->nullable();

            // Website display
            $table->boolean('is_popular')->default(false)->nullable();
            $table->boolean('is_featured')->default(false)->nullable();

            $table->integer('sort_order')->default(0)->nullable();

            // Active / inactive
            $table->boolean('status')->default(true)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};