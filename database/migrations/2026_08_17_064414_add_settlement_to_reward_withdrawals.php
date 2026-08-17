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
        Schema::table('reward_withdrawals', function (Blueprint $table) {

            $table->string('settlement_reference')
                ->nullable()
                ->after('payment_reference');

            $table->decimal('settled_amount', 12, 2)
                ->nullable()
                ->after('settlement_reference');

            $table->timestamp('settled_at')
                ->nullable()
                ->after('settled_amount');

            $table->unsignedBigInteger('settled_by')
                ->nullable()
                ->after('settled_at');

            $table->text('settlement_remark')
                ->nullable()
                ->after('settled_by');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reward_withdrawals', function (Blueprint $table) {
            //
        });
    }
};
