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
        Schema::table('customers', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | User / Referral
            |--------------------------------------------------------------------------
            */

            $table->string('userid')
                ->nullable()
                ->after('id');

            $table->string('old_name')
                ->nullable()
                ->after('name');

            $table->string('sponsor_id')
                ->nullable()
                ->after('mobile');

            $table->string('sponsor_name')
                ->nullable()
                ->after('sponsor_id');


            /*
            |--------------------------------------------------------------------------
            | Earnings
            |--------------------------------------------------------------------------
            */

            $table->double('bonus', 15, 2)
                ->nullable()
                ->default(0)
                ->after('wallet');


            /*
            |--------------------------------------------------------------------------
            | Package / Tree
            |--------------------------------------------------------------------------
            */

            $table->string('activation')
                ->nullable()
                ->default('no')
                ->after('longitude');

            $table->string('placedunder_id')
                ->nullable()
                ->index()
                ->after('activation');

            $table->enum('position', ['left', 'right'])
                ->nullable()
                ->after('placedunder_id');

            $table->text('rootmap')
                ->nullable()
                ->after('position');

            /*
            |--------------------------------------------------------------------------
            | Delete Status
            |--------------------------------------------------------------------------
            */

            $table->enum('is_deleted', ['yes', 'no'])
                ->default('no')
                ->after('is_block');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {

            $table->dropUnique([
                'customers_userid_unique'
            ]);

            $table->dropColumn([
                'userid',
                'old_name',
                'sponsor_id',
                'sponsor_name',
                'bonus',
                'activation',
                'placedunder_id',
                'position',
                'rootmap',
                'visiting_card_earned',
                'visiting_card_generated',
                'visiting_card_available',
                'is_deleted',
            ]);
        });
    }
};