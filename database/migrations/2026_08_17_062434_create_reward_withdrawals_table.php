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
        Schema::create('reward_withdrawals', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('customer_id')->nullable();

            $table->decimal('requested_amount', 12, 2)->nullable();

            $table->decimal('deduction_percentage', 5, 2)
                ->default(18.00)->nullable();

            $table->decimal('deduction_amount', 12, 2)->nullable();

            $table->decimal('payable_amount', 12, 2)->nullable();

            $table->decimal('opening_rewards', 12, 2)->nullable();

            $table->decimal('closing_rewards', 12, 2)
                ->nullable();

            $table->string('payment_method')->nullable();

            $table->string('payment_reference')->nullable();

            $table->text('admin_remark')->nullable();

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->nullable();

            $table->timestamp('approved_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reward_withdrawals');
    }
};
