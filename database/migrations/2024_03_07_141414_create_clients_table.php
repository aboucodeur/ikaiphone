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
        Schema::create('clients', function (Blueprint $table) {
            $table->id('c_id');
            $table->string('c_nom', 100);
            $table->string('c_tel', 25);
            $table->string('c_adr', 200);
            // simple ou revendeur
            $table->string('c_type', 10);
            $table->timestamps(); // [created|updated]_at
            // suppression en douce
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
