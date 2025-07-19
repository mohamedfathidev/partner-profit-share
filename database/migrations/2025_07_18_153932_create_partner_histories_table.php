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
        Schema::create('partner_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_id');
            $table->integer('year');
            $table->date('date');
            $table->decimal('initial_yearly_balance', 15, 2);
            $table->decimal('total_deposits', 15, 2);
            $table->decimal('total_withdrawals', 15, 2);
            $table->decimal('balance_after', 15, 2);
            $table->timestamps();

            // foreign ID 
            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partner_histories');
    }
};
