<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('customer_packages', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('customer_id')->nullable();

            $table->bigInteger('package_id')->nullable();

            $table->string('order_number')->nullable();

            $table->decimal('package_amount', 15, 2)->default(0)->nullable();
            $table->decimal('joining_amount', 15, 2)->default(0)->nullable();
            $table->decimal('total_amount', 15, 2)->default(0)->nullable();

            $table->string('payment_method')->nullable();

            $table->string('payment_reference')->nullable();

            $table->string('payment_receipt')->nullable();

            $table->enum('payment_status', [
                'pending',
                'approved',
                'rejected'
            ])->default('pending')->nullable();

            $table->enum('package_status', [
                'pending',
                'active',
                'inactive'
            ])->default('pending')->nullable();

            $table->foreignId('approved_by')->nullable();

            $table->timestamp('approved_at')->nullable();

            $table->timestamp('rejected_at')->nullable();

            $table->text('admin_remark')->nullable();

            $table->timestamp('activated_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_packages');
    }
};