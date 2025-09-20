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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('wallet_id');
            $table->enum('type', ['RECHARGE', 'PAYMENT']);
            $table->decimal('amount', 14, 2);
            $table->uuid('session_id')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('wallet_id')->references('id')->on('wallets');
            $table->foreign('session_id')->references('id')->on('payment_sessions');
            $table->index(['wallet_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
