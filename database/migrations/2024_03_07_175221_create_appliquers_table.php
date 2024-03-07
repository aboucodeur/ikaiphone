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
        // apres lier la migration au model parceque le s est enlever
        Schema::create('appliquer', function (Blueprint $table) {
            $table->id('ap_id');
            $table->unsignedBigInteger('v_id');
            $table->unsignedBigInteger('vr_id');
            // Clés étrangères
            $table->foreign('v_id')->references('v_id')->on('vendres');
            $table->foreign('vr_id')->references('vr_id')->on('vreductions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appliquer');
    }
};
