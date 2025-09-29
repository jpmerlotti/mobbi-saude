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
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users', 'id');
            $table->foreignId('equipment_type_id')->constrained('equipment_types', 'id');
            $table->uuid('public_id')->index('idx_public_id_equipments');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('daily_rate', 8, 2)->nullable();
            $table->boolean('is_rented')->default(false);
            $table->boolean('is_available')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipements');
    }
};
