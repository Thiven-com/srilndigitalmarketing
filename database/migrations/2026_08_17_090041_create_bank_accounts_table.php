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
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->string('user_role')->nullable();
            $table->string('account_name')->nullable();
            $table->string('bank_name')->nullable();
            $table->bigInteger('account_number')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('branch_name')->nullable();
            $table->enum('account_type', ['savings', 'current'])->nullable();
            $table->enum('bank_status', ['pending', 'approved', 'rejected'])->nullable()->default('pending');
            $table->string('upi_id')->nullable();
            $table->enum('upi_status', ['pending', 'approved', 'rejected'])->nullable()->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
