<?php

namespace App\Http\Controllers;

use App\Models\Sorteo;
use App\Models\Paquete;
use App\Models\Venta;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\VentaExitosaMail;

class SorteoController extends Controller
{
    public function index()
    {
        $sorteos = Sorteo::where('activo', true)
            ->withCount([
                'tickets as disponibles_count' => function ($query) {
                    $query->where('available', true);
                }
            ])
            ->get();

        if ($sorteos->count() === 1) {
            return redirect()->route('sorteo.show', $sorteos->first());
        }

        return view('home', compact('sorteos'));
    }

    public function show(Sorteo $sorteo)
    {
        if (!$sorteo->activo) {
            abort(404);
        }

        $sorteo->load('paquetes');
        $sorteo->loadCount([
            'tickets as disponibles_count' => function ($query) {
                $query->where('available', true);
            }
        ]);

        return view('index', compact('sorteo'));
    }

    public function buscar(Request $request)
    {
        $email = $request->input('email');
        $tickets = null;
        if ($email) {
            $tickets = Ticket::whereHas('venta', function ($q) use ($email) {
                $q->where('email_cliente', $email);
            })->with('sorteo')->get();
        }

        return view('buscar', compact('tickets'));
    }

    public function iniciarCheckout(Request $request)
    {
        $sorteo = Sorteo::findOrFail($request->sorteo_id);
        $paqueteId = $request->paquete_id;
        $cantidad = $request->cantidad ?? 1;

        $total = 0;
        $descripcion_compra = "";

        if ($paqueteId) {
            $paquete = Paquete::findOrFail($paqueteId);
            $total = $paquete->precio * $cantidad;
            $descripcion_compra = ($paquete->cantidad * $cantidad) . " Tickets (Paquete: {$paquete->cantidad} x {$cantidad})";
            $totalTicketsComprados = $paquete->cantidad * $cantidad;
        } else {
            $total = $sorteo->precio_ticket * $cantidad;
            $descripcion_compra = $cantidad . " Ticket(s) Individuales";
            $totalTicketsComprados = $cantidad;
        }

        return view('checkout', [
            'sorteo' => $sorteo,
            'paquete_id' => $paqueteId,
            'cantidad' => $cantidad,
            'total' => $total,
            'descripcion_compra' => $descripcion_compra,
            'total_tickets_comprados' => $totalTicketsComprados
        ]);
    }

    public function finalizarCheckout(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefono' => 'required|string|max:20',
        ]);

        $sorteo = Sorteo::findOrFail($request->sorteo_id);

        // Cantidad de tickets a comprar
        $cantidadTickets = ($request->paquete_id)
            ? (Paquete::findOrFail($request->paquete_id)->cantidad * $request->cantidad)
            : $request->cantidad;

        // Verificar disponibilidad real en base a tickets pre-generados
        $ticketsDisponiblesCount = $sorteo->tickets()->where('available', true)->count();
        if ($ticketsDisponiblesCount < $cantidadTickets) {
            return back()->with('error', 'Lo sentimos, solo quedan ' . $ticketsDisponiblesCount . ' tickets disponibles.');
        }

        $premiosGanados = [];
        $ticketModels = [];
        $venta = null;

        DB::transaction(function () use ($request, $sorteo, $cantidadTickets, &$venta, &$ticketModels, &$premiosGanados) {
            $venta = Venta::create([
                'sorteo_id' => $sorteo->id,
                'nombre_cliente' => $request->nombre,
                'email_cliente' => $request->email,
                'telefono_cliente' => $request->telefono,
                'total' => $request->total,
            ]);

            // 1. Intentar asignar tickets que TIENEN PREMIO primero (lógica de probabilidad)
            $ticketsConPremio = $sorteo->tickets()
                ->where('available', true)
                ->where('belongs_to_anticipated_prize', true)
                ->get();

            $cantidadPremiosAEntregar = 0;
            if ($ticketsConPremio->count() > 0) {
                $totalRestantes = $sorteo->tickets()->where('available', true)->count();
                for ($i = 0; $i < $cantidadTickets; $i++) {
                    // Si la suerte lo permite y el pool de premios no se ha agotado en este loop
                    if (count($ticketModels) < $cantidadTickets && rand(1, $totalRestantes) <= $ticketsConPremio->count()) {
                        $cantidadPremiosAEntregar++;
                    }
                }
            }

            // Asignar los tickets premiados seleccionados
            if ($cantidadPremiosAEntregar > 0) {
                $prizesToAssign = $ticketsConPremio->shuffle()->take($cantidadPremiosAEntregar);
                foreach ($prizesToAssign as $ticket) {
                    $ticket->update(['available' => false, 'venta_id' => $venta->id]);
                    $ticketModels[] = $ticket;
                    $premiosGanados[] = [
                        'numero' => $ticket->numero,
                        'premio' => $ticket->anticipated_prize_name
                    ];
                }
            }

            // 2. Asignar el resto de tickets de forma aleatoria de los que NO tienen premio (o no se seleccionaron como tales)
            $restantes = $cantidadTickets - count($ticketModels);
            if ($restantes > 0) {
                $ticketsAzar = $sorteo->tickets()
                    ->where('available', true)
                    ->inRandomOrder()
                    ->take($restantes)
                    ->get();

                foreach ($ticketsAzar as $ticket) {
                    $ticket->update(['available' => false, 'venta_id' => $venta->id]);
                    $ticketModels[] = $ticket;

                    // Si por puro azar sacó uno premiado que no forzamos arriba
                    if ($ticket->belongs_to_anticipated_prize) {
                        $premiosGanados[] = [
                            'numero' => $ticket->numero,
                            'premio' => $ticket->anticipated_prize_name
                        ];
                    }
                }
            }

            $sorteo->increment('tickets_vendidos', $cantidadTickets);
        });

        // Enviar Correo
        try {
            Mail::to($venta->email_cliente)->send(new VentaExitosaMail($venta, $ticketModels));
        } catch (\Exception $e) {
            \Log::error("Error enviando correo: " . $e->getMessage());
        }

        return view('confirmacion', [
            'tickets' => $ticketModels,
            'premiosGanados' => $premiosGanados
        ]);
    }
}
