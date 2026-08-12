<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('three_way_direct_referrals', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('customer_id')
                ->nullable();

            $table->string('userId', 250)->nullable();

            $table->string('sponser_id', 250)->nullable();

            $table->text('placedunder_id')->nullable();

            $table->decimal('left_points', 18, 6)->default(0)->nullable();

            $table->decimal('right_points', 18, 6)->default(0)->nullable();

            $table->decimal('total_income', 18, 2)->default(0)->nullable();

            $table->timestamp('last_settled_at')->nullable();

            $table->longText('rootmap')->nullable();

            $table->text('presenttime')->nullable();

            $table->string('points', 100)->default('0')->nullable();

            $table->string('edate', 225)->nullable();

            $table->string('g_count', 225)->default('0')->nullable();

            $table->string('g_reff', 225)->nullable();

            $table->integer('placedunderid_cnt')->default(0)->nullable();

            $table->integer('cron_start')->default(0)->nullable();

            $table->integer('cron_end')->default(0)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('three_way_direct_referrals');
    }
};