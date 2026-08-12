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
        Schema::create('rewards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();

            // user | agent | admin etc
            $table->string('role')->nullable();

            // Optional link to any activity / log table
            $table->unsignedBigInteger('activity_id')->nullable();

            // recharge | bbps_recharge | bill_payment | redeem | manual etc
            $table->string('source_type')->nullable();
            $table->string('source_id')->nullable();

            // cashback | points | voucher
            $table->string('reward_type')->nullable();

            // credit | debit
            $table->string('transaction_type')->nullable();

            // reward amount
            $table->decimal('amount', 12, 4)->nullable();

            // wallet balance before txn
            $table->decimal('opening_balance', 12, 4)->nullable();

            // wallet balance after txn
            $table->decimal('closing_balance', 12, 4)->nullable();

            // short description
            $table->string('description')->nullable();

            // pending | credited | debited | expired | reversed
            $table->string('status')->nullable();
            $table->integer('is_reverted')->nullable()->default(0);


            // rule / campaign / extra data
            $table->json('meta_data')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rewards');
    }
};
