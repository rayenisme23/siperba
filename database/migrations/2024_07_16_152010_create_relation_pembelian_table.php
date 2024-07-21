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
        Schema::create('relation_pembelian', function (Blueprint $table) {
            $table->id();
            $table->integer('qty');
            $table->integer('harga');
            $table->integer('total');
            $table->foreignId('pembelian_id')->references('id')->on('pembelian');
            $table->foreignId('bahanbaku_id')->references('id')->on('bahanbaku');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchaseorder');
    }
};
