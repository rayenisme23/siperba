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
        Schema::create('bahanbaku', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bahanbaku', 100);
            $table->integer('harga');
            $table->string('satuan', 20);
            $table->integer('stok');
            $table->date('tgl_exp')->nullable();
            $table->string('foto_bahanbaku', 100)->default('default.jpg');
            $table->integer('supplier_id')->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bahanbaku');
    }
};
