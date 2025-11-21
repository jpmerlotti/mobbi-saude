<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public string $prefix = 'contact_';
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->timestamp('expected_return_at')->nullable()->change();
            $table->string($this->prefix . 'name');
            $table->string($this->prefix . 'email')->nullable();
            $table->string($this->prefix . 'phone')->nullable();
            $table->string($this->prefix . 'type');
            $table->text($this->prefix . 'message')->nullable();
            $table->boolean($this->prefix . 'agree');
            $table->timestamp($this->prefix . 'agreed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->timestamp('expected_return_at')->nullable(false)->change();
            $table->dropColumn([
                $this->prefix . 'name',
                $this->prefix . 'email',
                $this->prefix . 'phone',
                $this->prefix . 'type',
                $this->prefix . 'message',
                $this->prefix . 'agree',
                $this->prefix . 'agreed_at',
            ]);
        });
    }
};
