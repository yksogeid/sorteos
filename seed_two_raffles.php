<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Sorteo;
use App\Models\Paquete;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

DB::transaction(function () {
    // Raffle 1: Toyota Fortuner
    $s1 = Sorteo::create([
        'titulo' => 'TOYOTA FORTUNER 125',
        'descripcion' => 'Participa por una Toyota Fortuner 2024 full equipo. ¡El premio de tus sueños!',
        'precio_ticket' => 50000,
        'total_tickets' => 1000,
        'activo' => true,
        'premios' => [
            ['nombre' => 'Toyota Fortuner 125', 'detalles' => ['Modelo 2024', '4x4', 'Full Equipo']],
            ['nombre' => 'Bono de $10,000,000', 'detalles' => ['Efectivo inmediato']],
        ]
    ]);

    Paquete::create(['sorteo_id' => $s1->id, 'precio' => 100000, 'cantidad' => 2, 'es_extra' => false]);
    Paquete::create(['sorteo_id' => $s1->id, 'precio' => 250000, 'cantidad' => 6, 'es_extra' => true]);

    $tickets1 = [];
    for ($i = 0; $i < 1000; $i++) {
        $tickets1[] = [
            'sorteo_id' => $s1->id,
            'numero' => str_pad($i, 5, '0', STR_PAD_LEFT),
            'available' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
    Ticket::insert($tickets1);

    // Raffle 2: Apartamento de Lujo
    $s2 = Sorteo::create([
        'titulo' => 'APARTAMENTO DE LUJO EN CARTAGENA',
        'descripcion' => 'Un apartamento frente al mar con todas las comodidades. ¡Vive tus vacaciones para siempre!',
        'precio_ticket' => 150000,
        'total_tickets' => 500,
        'activo' => true,
        'premios' => [
            ['nombre' => 'Apartamento 302', 'detalles' => ['Vista al mar', 'Amoblado', 'Piscina privada']],
            ['nombre' => 'Bono de $5,000,000', 'detalles' => ['Para gastos de escrituración']],
        ]
    ]);

    Paquete::create(['sorteo_id' => $s2->id, 'precio' => 300000, 'cantidad' => 2, 'es_extra' => false]);
    Paquete::create(['sorteo_id' => $s2->id, 'precio' => 700000, 'cantidad' => 5, 'es_extra' => true]);

    $tickets2 = [];
    for ($i = 0; $i < 500; $i++) {
        $tickets2[] = [
            'sorteo_id' => $s2->id,
            'numero' => str_pad($i, 5, '0', STR_PAD_LEFT),
            'available' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
    Ticket::insert($tickets2);
});

echo "Dos sorteos creados correctamente.\n";
