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
        Schema::create('kas_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('approved_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('bill_id')->constrained('bills')->cascadeOnDelete();

            $table->timestamp('paid_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->enum('payment_method', ['cash'])->nullable();
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kas_payments');
    }
};
