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
        Schema::create('private_credit_fees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['percentage', 'fixed']);
            $table->enum('calculate_on', ['principal', 'interest', 'principal_and_interest'])->default('principal');
            $table->decimal('value', 8, 4);
            $table->boolean('is_active_deduct_from_principal')->default(false);
            $table->boolean('is_active_spread_across_repayments')->default(false);
            $table->timestamps();
        });

        Schema::create('private_credit_loan_product_fee', function (Blueprint $table) {
            $table->foreignId('loan_product_id')->constrained('private_credit_loan_products')->onDelete('cascade');
            $table->foreignId('fee_id')->constrained('private_credit_fees')->onDelete('cascade');
            $table->primary(['loan_product_id', 'fee_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('private_credit_loan_product_fee');
        Schema::dropIfExists('private_credit_fees');
    }
};
