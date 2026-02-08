<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paquete extends Model
{
    protected $fillable = ['sorteo_id', 'cantidad', 'precio', 'es_extra'];

    protected $casts = [
        'es_extra' => 'boolean',
    ];

    public function sorteo()
    {
        return $this->belongsTo(Sorteo::class);
    }
}
