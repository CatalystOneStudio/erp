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
        Schema::create('private_credit_loan_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('min_principal_amount');
            $table->unsignedBigInteger('max_principal_amount');
            $table->enum('duration_period', ['years', 'months', 'weeks', 'days']);
            $table->enum('duration_type', ['fixed', 'interval']);
            $table->unsignedSmallInteger('duration_value')->default(0);
            $table->unsignedSmallInteger('duration_min_value')->default(0);
            $table->unsignedSmallInteger('duration_max_value')->default(0);
            $table->enum('repayment_cycle', ['once', 'daily', 'weekly', 'bi-weekly', 'monthly', 'quarterly', 'semi-annual', 'per-year']);
            $table->enum('interest_rate_type', ['flat', 'armotized']);
            $table->decimal('interest_rate', 8, 4);
            $table->enum('interest_cycle', ['once', 'per-day', 'per-week', 'per-month', 'per-year']);

            $table->boolean('late_penalty_is_active')->default(false);
            $table->enum('late_penalty_type', ['fixed', 'percentage'])->default('fixed');
            $table->enum('late_penalty_calculate_on', ['principal', 'interest', 'principal_and_interest'])->default('principal');
            $table->decimal('late_penalty_amount', 8, 4)->default(0);
            $table->unsignedSmallInteger('late_penalty_grace_period')->default(0);
            $table->enum('late_penalty_recurring', ['once', 'daily', 'weekly', 'bi-weekly', 'monthly', 'quarterly', 'semi-annual', 'per-year'])->default('once');

            $table->foreignId('funding_account_id')->nullable()->constrained('private_credit_chart_of_accounts')->nullOnDelete();
            $table->foreignId('loans_receivable_account_id')->nullable()->constrained('private_credit_chart_of_accounts')->nullOnDelete();
            $table->foreignId('default_interest_income_account_id')->nullable()->constrained('private_credit_chart_of_accounts')->nullOnDelete();
            $table->foreignId('default_fees_income_account_id')->nullable()->constrained('private_credit_chart_of_accounts')->nullOnDelete();
            $table->foreignId('default_penalty_income_account_id')->nullable()->constrained('private_credit_chart_of_accounts')->nullOnDelete();
            $table->foreignId('default_overpayment_account_id')->nullable()->constrained('private_credit_chart_of_accounts')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('private_credit_loan_products');
    }
};
