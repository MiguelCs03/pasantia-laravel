<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cliente_id',
        'fecha',
        'estado',
        'total',
        'observaciones'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha' => 'date',
        'total' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the cliente that owns the orden.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Get the detalles for the orden.
     */
    public function detalles()
    {
        return $this->hasMany(OrdenDetalle::class);
    }

    /**
     * Calculate and update the total from detalles.
     */
    public function calcularTotal()
    {
        $this->total = $this->detalles()->sum('subtotal');
        $this->save();
        return $this->total;
    }
}
