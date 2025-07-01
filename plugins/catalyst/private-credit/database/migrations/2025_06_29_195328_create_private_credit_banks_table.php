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
        Schema::create('private_credit_banks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('swift_code', 11)->nullable();
            $table->string('routing_number', 20)->nullable();
            $table->string('country', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('private_credit_banks');
    }
};
