<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Sorteo;

$sorteo = Sorteo::where('activo', true)->first();
if ($sorteo) {
    echo "ID: " . $sorteo->id . "\n";
    echo "Total Tickets: " . $sorteo->total_tickets . "\n";
    echo "Vendidos: " . $sorteo->tickets_vendidos . "\n";
    echo "DB Total: " . $sorteo->tickets()->count() . "\n";
    echo "DB Disponibles: " . $sorteo->tickets()->where('available', true)->count() . "\n";
    echo "Paquetes: " . $sorteo->paquetes->count() . "\n";
    foreach ($sorteo->paquetes as $p) {
        echo " - ID: " . $p->id . ", Cantidad: " . $p->cantidad . "\n";
    }
} else {
    echo "No hay sorteo activo.\n";
}
