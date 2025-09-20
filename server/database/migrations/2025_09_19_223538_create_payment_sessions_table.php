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
        Schema::create('payment_sessions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('customer_id');
            $table->decimal('amount', 14, 2);
            $table->char('otp', 6);
            $table->enum('status', ['PENDING','CONFIRMED','EXPIRED'])->default('PENDING');
            $table->timestamp('expires_at');
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->index(['customer_id','status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_sessions');
    }
};
