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
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->uuid('public_id')->index('idx_public_id_rentals');
            $table->foreignId('equipment_id')->constrained('equipments', 'id');
            $table->foreignId('borrower_id')->constrained('users', 'id');

            $table->timestamp('rented_at')->nullable(); 
            $table->timestamp('expected_return_at'); 
            $table->timestamp('returned_at')->nullable();

            $table->string('status')->default('pending_approval');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
