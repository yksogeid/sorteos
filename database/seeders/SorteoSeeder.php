<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sorteo;
use App\Models\Paquete;

class SorteoSeeder extends Seeder
{
    public function run(): void
    {
        $sorteo = Sorteo::create([
            'titulo' => 'PLATA, CASA Y MOTO',
            'descripcion' => 'A ESTRENAR SE DIJO',
            'imagen' => 'banner_sorteo.png',
            'precio_ticket' => 1000,
            'total_tickets' => 100000,
            'tickets_vendidos' => 32000,
            'activo' => true,
            'premios' => [
                [
                    'nombre' => 'Premio Mayor',
                    'subtitulo' => 'Motorcycle and Car',
                    'prizes' => ['Moto XTZ 250', 'Toyota TXL']
                ],
                [
                    'nombre' => 'Premio Invertido',
                    'subtitulo' => 'Playstation 5',
                    'prizes' => ['PS5']
                ]
            ],
            'numeros_anticipados' => [
                ['titulo' => 'Iphone 17 pro max', 'numeros' => ['25878']],
                ['titulo' => 'Play station 5', 'numeros' => ['48775', '12336']],
                ['titulo' => '$1.000.000', 'numeros' => ['58776', '55214', '30092', '45877']],
                ['titulo' => '$500.000', 'numeros' => ['12241', '23654', '12012', '14878']],
            ]
        ]);

        Paquete::create(['sorteo_id' => $sorteo->id, 'cantidad' => 50, 'precio' => 50000, 'es_extra' => false]);
        Paquete::create(['sorteo_id' => $sorteo->id, 'cantidad' => 100, 'precio' => 100000, 'es_extra' => false]);
        Paquete::create(['sorteo_id' => $sorteo->id, 'cantidad' => 150, 'precio' => 150000, 'es_extra' => false]);
        Paquete::create(['sorteo_id' => $sorteo->id, 'cantidad' => 250, 'precio' => 100000, 'es_extra' => true]);
        Paquete::create(['sorteo_id' => $sorteo->id, 'cantidad' => 350, 'precio' => 100000, 'es_extra' => true]);
        Paquete::create(['sorteo_id' => $sorteo->id, 'cantidad' => 450, 'precio' => 100000, 'es_extra' => true]);
    }
}
