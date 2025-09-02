<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orden_id')->constrained('ordens')->onDelete('cascade');
            $table->enum('metodo_pago', ['efectivo', 'qr', 'tarjeta']);
            $table->decimal('monto', 10, 2);
            $table->text('detalles')->nullable(); // Para info adicional como número de tarjeta, referencia QR, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orden_pagos');
    }
};
