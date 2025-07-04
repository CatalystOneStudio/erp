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
        Schema::create('private_credit_loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrower_id')->constrained('users')->nullOnDelete();
            $table->enum('loan_status', ['requested', 'processing', 'active', 'defaulted', 'denied']);

            // Loan Details
            $table->decimal('principal_amount', 12, 4);
            $table->date('loan_release_date');
            $table->integer('loan_duration');
            $table->enum('duration_period', ['days', 'weeks', 'months', 'years']);
            $table->enum('interest_method', ['flat', 'amortized']);
            $table->decimal('interest_rate', 12, 4);
            $table->enum('interest_cycle', ['once', 'per-day', 'per-week', 'per-month', 'per-year']);
            $table->enum('repayment_cycle', ['once', 'daily', 'weekly', 'bi-weekly', 'monthly', 'quarterly', 'semi-annual', 'per-year']);

            // Custom Repayment Schedule
            $table->boolean('custom_repayment_schedule_enabled')->default(false);
            $table->json('custom_repayment_days')->nullable();

            // Late Repayment Penalty
            $table->boolean('late_penalty_is_active')->default(false);
            $table->enum('late_penalty_type', ['fixed', 'percentage'])->default('fixed');
            $table->enum('late_penalty_calculate_on', ['principal', 'interest', 'principal_and_interest'])->default('principal');
            $table->decimal('late_penalty_amount', 12, 4)->default(0);
            $table->unsignedSmallInteger('late_penalty_grace_period')->default(0);
            $table->enum('late_penalty_recurring', ['once', 'daily', 'weekly', 'bi-weekly', 'monthly', 'quarterly', 'semi-annual', 'per-year'])->default('once');

            // Accounts
            $table->foreignId('funding_account_id')->nullable()->constrained('private_credit_chart_of_accounts')->nullOnDelete();
            $table->foreignId('loans_receivable_account_id')->nullable()->constrained('private_credit_chart_of_accounts')->nullOnDelete();
            $table->foreignId('default_interest_income_account_id')->nullable()->constrained('private_credit_chart_of_accounts')->nullOnDelete();
            $table->foreignId('default_fees_income_account_id')->nullable()->constrained('private_credit_chart_of_accounts')->nullOnDelete();
            $table->foreignId('default_penalty_income_account_id')->nullable()->constrained('private_credit_chart_of_accounts')->nullOnDelete();
            $table->foreignId('default_overpayment_account_id')->nullable()->constrained('private_credit_chart_of_accounts')->nullOnDelete();

            // Collateral Details
            $table->string('collateral_name')->nullable();
            $table->text('collateral_description')->nullable();
            $table->text('collateral_defects')->nullable();
            $table->json('collateral_files')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('private_credit_loans');
    }
};
