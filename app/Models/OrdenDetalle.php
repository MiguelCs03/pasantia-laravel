<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenDetalle extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'orden_id',
        'producto_id',
        'producto',
        'cantidad',
        'precio_unitario',
        'subtotal'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'cantidad' => 'integer',
        'precio_unitario' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the orden that owns the detalle.
     */
    public function orden()
    {
        return $this->belongsTo(Orden::class);
    }

    /**
     * Get the producto that owns the detalle.
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    /**
     * Calculate subtotal before saving.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($detalle) {
            $detalle->subtotal = $detalle->cantidad * $detalle->precio_unitario;
        });

        static::saved(function ($detalle) {
            $detalle->orden->calcularTotal();
        });

        static::deleted(function ($detalle) {
            $detalle->orden->calcularTotal();
        });
    }
}
