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
        Schema::create('point_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('point_id')->constrained('points');
            $table->enum('transaction_type', ['earn', 'spend']);
            $table->integer('point');
            $table->unsignedBigInteger('consumer_pickup_id')->nullable();
            $table->foreignId('reward_id')->nullable()->constrained('rewards');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('point_transactions');
    }
};
