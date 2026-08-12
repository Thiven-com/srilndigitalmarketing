<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('package_components', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('package_id')->nullable();

            /*
             * direct
             * company
             * expense
             * sharing
             * bonus
             */
            $table->string('component_type')->nullable();

            $table->string('name')->nullable();

            $table->string('code')->nullable();

            /*
             * fixed
             * percentage
             */
            $table->enum('calculation_type', [
                'fixed',
                'percentage',
            ])->default('fixed')->nullable();

            /*
             * Fixed amount
             */
            $table->decimal('amount', 12, 2)
                ->nullable();

            /*
             * Percentage value
             */
            $table->decimal('percentage', 8, 2)
                ->nullable();

            /*
             * NULL = package-level component
             * 1    = Level 1
             * 2    = Level 2
             * ...
             * 6    = Level 6
             */
            $table->unsignedTinyInteger('level')
                ->nullable();

            /*
             * Optional qualification
             */
            $table->decimal('minimum_amount', 12, 2)
                ->nullable();

            $table->decimal('maximum_amount', 12, 2)
                ->nullable();

            /*
             * Whether this component is compulsory
             */
            $table->boolean('is_mandatory')
                ->default(false)->nullable();

            $table->text('description')
                ->nullable();

            $table->unsignedInteger('sort_order')
                ->default(0)->nullable();

            $table->boolean('status')->default(true)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_components');
    }
};