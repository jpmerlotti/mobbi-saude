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
        Schema::create('equipment_types', function (Blueprint $table) {
            $table->id();
            $table->uuid('public_id')
                ->index('idx_public_id_equipment_types');
            
            $table->string('name')
                ->unique();
            
            $table->string('slug')
                ->unique()
                ->index('idx_slug_equipment_types');
            
            $table->string('description')
                ->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipement_types');
    }
};
