<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sorteo extends Model
{
    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'precio_ticket',
        'total_tickets',
        'tickets_vendidos',
        'activo',
        'premios',
        'numeros_anticipados'
    ];

    protected $attributes = [
        'premios' => '[]',
        'numeros_anticipados' => '[]',
        'tickets_vendidos' => 0,
    ];

    protected $casts = [
        'premios' => 'array',
        'numeros_anticipados' => 'array',
        'activo' => 'boolean',
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
