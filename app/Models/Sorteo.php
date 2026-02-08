<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sorteo extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'precio_ticket',
        'total_tickets',
        'tickets_vendidos',
        'activo',
        'premios',
        'numeros_anticipados',
        'porcentaje_manual',
        'proceso_manual'
    ];

    protected $attributes = [
        'premios' => '[]',
        'numeros_anticipados' => '[]',
        'tickets_vendidos' => 0,
        'porcentaje_manual' => 0,
        'proceso_manual' => false,
    ];

    protected $casts = [
        'premios' => 'array',
        'numeros_anticipados' => 'array',
        'activo' => 'boolean',
        'proceso_manual' => 'boolean',
    ];

    public function paquetes()
    {
        return $this->hasMany(Paquete::class);
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
