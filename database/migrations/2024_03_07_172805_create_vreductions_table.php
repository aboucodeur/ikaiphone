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
        Schema::create('vreductions', function (Blueprint $table) {
            $table->id('vr_id');
            $table->integer('vr_etat')->default(0);
            $table->unsignedBigInteger('r_id');
            $table->foreign('r_id')->references('r_id')->on('reductions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vreductions');
    }
};
