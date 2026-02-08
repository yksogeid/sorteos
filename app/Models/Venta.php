<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable = [
        'sorteo_id',
        'nombre_cliente',
        'email_cliente',
        'telefono_cliente',
        'total'
    ];

    public function sorteo()
    {
        return $this->belongsTo(Sorteo::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
