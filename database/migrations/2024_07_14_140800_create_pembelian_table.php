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
        Schema::create('pembelian', function (Blueprint $table) {
            $table->id();
            $table->string('no_po');
            $table->integer('supplier_id');
            $table->integer('bahanbaku_id');
            $table->integer('qty');
            $table->integer('harga');
            $table->integer('subtotal');
            $table->integer('users_id');
            $table->enum('status', ['Diproses', 'Diterima'])->default('Diproses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian');
    }
};
