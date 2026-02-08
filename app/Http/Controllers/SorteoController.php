<?php

namespace App\Http\Controllers;

use App\Models\Sorteo;
use App\Models\Paquete;
use App\Models\Venta;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\VentaExitosaMail;

class SorteoController extends Controller
{
    public function index()
    {
        $sorteo = Sorteo::with('paquetes')->where('activo', true)->first();
        if (!$sorteo)
            abort(404, 'No hay sorteos activos.');

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

        $venta = Venta::create([
            'sorteo_id' => $sorteo->id,
            'nombre_cliente' => $request->nombre,
            'email_cliente' => $request->email,
            'telefono_cliente' => $request->telefono,
            'total' => $request->total,
        ]);

        // Determinar cuántos tickets generar
        $cantidadTickets = 0;
        if ($request->paquete_id) {
            $paquete = Paquete::findOrFail($request->paquete_id);
            $cantidadTickets = $paquete->cantidad * $request->cantidad;
        } else {
            $cantidadTickets = $request->cantidad;
        }

        // Generar tickets
        $ticketsGenerados = $this->generateRandomTickets($sorteo, $cantidadTickets);

        $ticketModels = [];
        foreach ($ticketsGenerados as $num) {
            $ticketModels[] = Ticket::create([
                'venta_id' => $venta->id,
                'sorteo_id' => $sorteo->id,
                'numero' => $num,
            ]);
        }

        // Actualizar contador del sorteo
        $sorteo->increment('tickets_vendidos', $cantidadTickets);

        // Enviar Correo
        try {
            Mail::to($venta->email_cliente)->send(new VentaExitosaMail($venta, $ticketModels));
        } catch (\Exception $e) {
            // Log error or ignore for demo if mail is not configured
            \Log::error("Error enviando correo: " . $e->getMessage());
        }

        return view('confirmacion', ['tickets' => $ticketModels]);
    }

    private function generateRandomTickets($sorteo, $cantidad)
    {
        $tickets = [];
        $totalPossible = $sorteo->total_tickets;

        $taken = Ticket::where('sorteo_id', $sorteo->id)->pluck('numero')->toArray();

        // Use a set for faster lookup
        $takenSet = array_flip($taken);
        $newTickets = [];

        $attempts = 0;
        while (count($newTickets) < $cantidad && $attempts < 1000) {
            $num = str_pad(rand(0, $totalPossible - 1), 5, '0', STR_PAD_LEFT);
            if (!isset($takenSet[$num]) && !isset($newTickets[$num])) {
                $newTickets[$num] = true;
            }
            $attempts++;
        }

        return array_keys($newTickets);
    }
}
