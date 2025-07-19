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
        Schema::create('month_profits', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('month')->check('month BETWEEN 1 AND 12');
            $table->smallInteger('year')->unsigned()->check('year >= 2000');
            $table->decimal('total_profit', 10, 2);
            $table->decimal('unused_goods', 10, 2);
            $table->decimal('distribution_profit', 10, 2)->default(0);
            $table->integer('version')->default(1);
            $table->unique(['version', 'month', 'year']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('month_profits');
    }
};
