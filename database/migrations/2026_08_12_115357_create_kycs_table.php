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
        Schema::create('kycs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->string('user_role')->nullable();
            $table->string('aadhaar_no')->nullable();
            $table->string('aadhaar_image')->nullable();
            $table->timestamp('aadhaar_verified_at')->nullable();
            $table->enum('aadhar_status', ['pending', 'approved', 'rejected'])->nullable()->default('pending');
            $table->string('pan_no')->nullable();
            $table->timestamp('pan_verified_at')->nullable();
            $table->enum('pan_status', ['pending', 'approved', 'rejected'])->nullable()->default('pending');
            $table->string('gst')->nullable();
            $table->text('gst_name')->nullable();
            $table->text('gst_address')->nullable();
            $table->string('gst_type')->nullable();
            $table->string('gst_image', 500)->nullable();
            $table->enum('gst_status', ['pending', 'approved', 'rejected'])
                ->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kycs');
    }
};
