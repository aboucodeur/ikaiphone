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
        Schema::create('reductions', function (Blueprint $table) {
            $table->id('r_id');
            $table->string('r_nom', 50)->unique();
            $table->char('r_type', 3)->nullable(); // remise ou rabais
            $table->decimal('r_pourcentage', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reductions');
    }
};
