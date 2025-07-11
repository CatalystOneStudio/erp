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
            $table->decimal('value', 12, 4);
            $table->boolean('is_active_deduct_from_principal')->default(false);
            $table->boolean('is_active_spread_across_repayments')->default(false);

            $table->morphs('feesable');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('private_credit_fees');
    }
};
