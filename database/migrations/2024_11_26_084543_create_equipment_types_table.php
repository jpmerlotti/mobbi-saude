<?php

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    use HasUuids;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('equipments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('equipment_type_id');
            $table->uuid('owner_id');
            $table->string('photo');
            $table->string('name');
            $table->text('description');
            $table->string('status');
            $table->boolean('active');
            $table->timestamps();

            $table->foreign('equipment_type_id')->references('id')->on('equipment_types');
            $table->foreign('owner_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipments');
    }
};
