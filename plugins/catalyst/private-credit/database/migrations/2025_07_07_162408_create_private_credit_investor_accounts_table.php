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
        Schema::create('private_credit_investor_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('investor_id')->constrained('private_credit_investors')->cascadeOnDelete();
            $table->foreignId('investor_product_id')->constrained('private_credit_investor_products')->cascadeOnDelete();
            $table->string('account_code')->unique();
            $table->decimal('balance', 14, 4)->default(0.00);
            $table->decimal('total_deposits', 14, 4)->default(0.00);
            $table->decimal('total_withdrawals', 14, 4)->default(0.00);
            $table->decimal('total_bank_fees', 14, 4)->default(0.00);
            $table->decimal('total_interest_earned', 14, 4)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('private_credit_investor_accounts');
    }
};
