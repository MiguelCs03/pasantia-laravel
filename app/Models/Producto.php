<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'codigo',
        'categoria',
        'estado'
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'stock' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relación con orden_detalles
     */
    public function ordenDetalles()
    {
        return $this->hasMany(OrdenDetalle::class);
    }

    /**
     * Scope para productos activos
     */
    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

    /**
     * Scope para productos con stock
     */
    public function scopeConStock($query)
    {
        return $query->where('stock', '>', 0);
    }
}
