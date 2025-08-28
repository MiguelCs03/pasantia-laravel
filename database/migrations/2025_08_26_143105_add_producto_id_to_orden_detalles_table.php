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
        Schema::table('orden_detalles', function (Blueprint $table) {
            // añadiendo llave de realcion con tabla producto 
            $table->foreignId('producto_id')->nullable()->after('orden_id')->constrained('productos')->onDelete('cascade');
            
            // El campo 'producto' seguirá existiendo para compatibilidad con datos existentes
            // pero ahora será opcional cuando se use la llave de la tabla producto
            $table->string('producto', 200)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orden_detalles', function (Blueprint $table) {
            $table->dropForeign(['producto_id']);
            $table->dropColumn('producto_id');
            $table->string('producto', 200)->nullable(false)->change();
        });
    }
};
