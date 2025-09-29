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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->uuid('public_id')
                ->index('idx_public_id_contracts');

            $table->foreignId('rental_id')->constrained('rentals', 'id');

            $table->string('type');
            $table->longText('content');


            $table->timestamp('leesee_signed_at')->nullable();
            $table->text('leessee_signature_data')->nullable();

            $table->timestamp('leessor_signed_at')->nullable();
            $table->text('leessor_signature_data')->nullable();

            $table->string('status')->default('pending_signatures');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
