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
        Schema::create('retours', function (Blueprint $table) {
            $table->id('re_id');
            $table->date('re_date')->default('now()');
            $table->string('re_motif')->nullable();
            $table->smallInteger('etat')->default(0);
            $table->timestamps();
            $table->unsignedBigInteger('i_id');
            $table->unsignedBigInteger('i_ech_id');
            $table->unsignedBigInteger('en_id');
            $table->foreign('en_id')->references('en_id')->on('entreprises')->cascadeOnUpdate();
            $table->foreign('i_id')->references('i_id')->on('iphones')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('i_ech_id')->references('i_id')->on('iphones')->cascadeOnUpdate()->cascadeOnDelete();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retours');
    }
};
