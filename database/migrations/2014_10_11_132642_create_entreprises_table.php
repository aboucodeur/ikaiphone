<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entreprises', function (Blueprint $table) {
            $table->id('en_id');
            $table->string('en_nom', 200);
            $table->string('en_desc', 255);
            $table->string('en_tel', 25);
            $table->string('en_adr', 200);
            $table->string('en_email', 100)->nullable();
            $table->string('en_logo', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entreprises');
    }
};
