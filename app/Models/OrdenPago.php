<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenPago extends Model
{
    use HasFactory;

    protected $table = 'orden_pagos'; 

    protected $fillable = [
        'orden_id', 
        'metodo_pago', 
        'monto',
        'detalles'
    ]; 

    protected $casts = [
        'monto'=> 'decimal:2', 
        'created_at' =>'datetime', 
        'update:at' => 'datetime',
    ]; 

    // relacion cno la tabla orden 
    
    public function orden(){
        return $this->belongsto(Orden::class); 
    }
}
