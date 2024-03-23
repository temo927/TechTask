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
        Schema::create('prize_assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rank_group_id');
            $table->foreign('rank_group_id')->references('id')->on('rank_groups')->onDelete('cascade');
            $table->decimal('prize_amount_usd', 10, 2);
            $table->integer('prize_number');
            $table->decimal('odds_of_winning', 8, 6);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prize_assignments');
    }
};
