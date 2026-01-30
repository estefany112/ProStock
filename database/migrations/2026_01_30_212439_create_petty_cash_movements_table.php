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
        Schema::create('petty_cash_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('petty_cash_id')->constrained();
            $table->enum('type', ['income', 'expense']);
            $table->decimal('amount', 10, 2);
            $table->string('concept');
            $table->string('voucher')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('petty_cash_movements');
    }
};
