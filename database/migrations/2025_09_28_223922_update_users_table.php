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
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('public_id')
                ->after('id')
                ->index('idx_public_id_users');

            $table->string('phone')->nullable()->after('email');
            $table->string('document')->unique()->nullable()->after('phone');

            $table->string('address_street')->nullable()->after('password');
            $table->string('address_number')->nullable()->after('address_street');
            $table->string('address_complement')->nullable()->after('address_number');
            $table->string('address_district')->nullable()->after('address_complement');
            $table->string('address_city')->nullable()->after('address_district');
            $table->string('address_state', 2)->nullable()->after('address_city');
            $table->string('address_zip_code')->nullable()->after('address_state');    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('idx_public_id_users');
            $table->dropColumn([
                'public_id',
                'phone',
                'document',
                'address_street',
                'address_number',
                'address_complement',
                'address_district',
                'address_city',
                'address_state',
                'address_zip_code',
            ]);
        });
    }
};
