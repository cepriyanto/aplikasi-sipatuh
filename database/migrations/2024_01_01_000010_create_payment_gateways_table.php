<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembayaran_id')->constrained('pembayarans')->onDelete('cascade');
            $table->string('gateway', 50);
            $table->string('transaction_id', 100);
            $table->string('status', 50);
            $table->text('response')->nullable();
            $table->timestamps();
            
            $table->index('pembayaran_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_gateways');
    }
};