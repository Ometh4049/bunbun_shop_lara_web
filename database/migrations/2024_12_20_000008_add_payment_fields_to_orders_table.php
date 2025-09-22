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
        Schema::table('orders', function (Blueprint $table) {
    if (!Schema::hasColumn('orders', 'payment_method')) {
        $table->string('payment_method')->default('cash')->after('order_type');
    }

    if (!Schema::hasColumn('orders', 'payment_status')) {
        $table->enum('payment_status', ['pending', 'completed', 'failed', 'refunded'])
              ->default('pending')
              ->after('payment_method');
    }

    if (!Schema::hasColumn('orders', 'transaction_id')) {
        $table->string('transaction_id')->nullable()->after('payment_status');
    }
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'payment_status', 'transaction_id']);
        });
    }
};
