<?php

use App\Models\Transaction;
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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->noActionOnDelete();
            $table->string('title');
            $table->enum('type', [
                Transaction::TYPE_INCOME,
                Transaction::TYPE_EXPENSE
            ]);
            $table->decimal('amount', 15, 2);
            $table->date('date');
            $table->string('reference_number')->nullable();
            $table->string('payee_payer');
            $table->string('description')->nullable();
            $table->enum('payment_method',[
                Transaction::METHOD_POSE,
                Transaction::METHOD_CARD,
                Transaction::METHOD_ONLINE,
                Transaction::METHOD_CASH,
                Transaction::METHOD_BANK,
                Transaction::METHOD_CHECK,
                Transaction::METHOD_OTHERS,
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
