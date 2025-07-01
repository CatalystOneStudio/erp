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
        Schema::create('private_credit_chart_of_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('name');
            $table->string('code', 100)->unique();
            $table->text('description')->nullable();
            $table->enum('account_type', ['asset', 'liability', 'equity', 'income', 'expense']);
            $table->enum('cashflow_type', ['none', 'operating_activities', 'investing_activities', 'financing_activities']);
            $table->boolean('is_enabled')->default(true);
            $table->timestamps();
        });

        Schema::table('private_credit_chart_of_accounts', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('private_credit_chart_of_accounts')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('private_credit_chart_of_accounts');
    }
};
