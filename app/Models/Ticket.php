<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = ['venta_id', 'sorteo_id', 'numero', 'available', 'belongs_to_anticipated_prize', 'anticipated_prize_name'];

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

    public function sorteo()
    {
        return $this->belongsTo(Sorteo::class);
    }
}
