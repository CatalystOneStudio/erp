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
        Schema::create('private_credit_funding_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('parent_id')->nullable();
            $table->string('name');
            $table->string('code', 100)->nullable();
            $table->string('currency', 3)->default('TTD');
            $table->enum('account_type', ['cash', 'bank']);
            $table->foreignId('bank_id')->nullable()->constrained('private_credit_banks')->onDelete('set null');
            $table->string('bank_account_number')->nullable();
            $table->string('bank_account_holder_name')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::table('private_credit_funding_accounts', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('private_credit_funding_accounts')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('private_credit_funding_accounts');
    }
};
