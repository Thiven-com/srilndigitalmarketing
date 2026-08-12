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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();

            $table->double('wallet',15,2)->nullable()->default(0);
            $table->double('rewards',15,2)->nullable()->default(0);

            $table->date('dob')->nullable();
            $table->string('otp')->nullable();
            $table->double('latitude', 15, 8)->nullable();
            $table->double('longitude', 15, 8)->nullable();

            $table->enum('kyc_status', ['pending', 'approved', 'rejected'])->nullable()->default('pending');
            $table->string('profile_pic')->nullable();
            $table->enum('mobile_verified', ['yes', 'no'])->nullable()->default('no');
            $table->enum('email_verified', ['yes', 'no'])->nullable()->default('no');
            $table->timestamp('mobile_verified_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('firebase_token')->nullable();
            $table->string('remember_token')->nullable();
            $table->enum('is_verify', ['yes', 'no'])->default('no');
            $table->enum('is_block', ['yes', 'no'])->default('no');
            $table->string('account_status')->nullable()->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
