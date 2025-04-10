<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profit_shares', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->decimal('profit_share', 10, 2)->check('profit_share >= 0');
            $table->morphs('profitable'); // Adds profitable_id and profitable_type
            $table->foreignId('month_profit_id')->constrained('month_profits')->onDelete('cascade');
            $table->unique(['profitable_id', 'profitable_type', 'month_profit_id'], 'profit_shares_unique_idx');  // // Shortened index name
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profit_shares');
    }
};
