<?php

namespace App\Http\Controllers;

use App\Models\Sorteo;
use App\Models\Paquete;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $sorteos = Sorteo::withCount([
            'tickets as vendidos_count' => function ($query) {
                $query->where('available', false);
            }
        ])->get();
        return view('admin.index', compact('sorteos'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio_ticket' => 'required|numeric',
            'total_tickets' => 'required|integer|min:1',
            'porcentaje_manual' => 'nullable|integer|min:0|max:100',
        ]);

        DB::transaction(function () use ($request, $data) {
            $data['activo'] = $request->has('activo');
            $data['proceso_manual'] = $request->has('proceso_manual');
            $data['porcentaje_manual'] = $request->input('porcentaje_manual', 0);
            $data['premios'] = [];
            $data['numeros_anticipados'] = [];

            if ($request->hasFile('imagen')) {
                $path = $request->file('imagen')->store('sorteos', 'public');
                $data['imagen'] = $path;
            }

            $sorteo = Sorteo::create($data);

            // Pre-generar tickets de forma masiva (Bulk Insert)
            $tickets = [];
            for ($i = 0; $i < $data['total_tickets']; $i++) {
                $tickets[] = [
                    'sorteo_id' => $sorteo->id,
                    'numero' => str_pad($i, 5, '0', STR_PAD_LEFT),
                    'available' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                if (count($tickets) >= 1000) {
                    Ticket::insert($tickets);
                    $tickets = [];
                }
            }
            if (!empty($tickets)) {
                Ticket::insert($tickets);
            }
        });

        return redirect()->route('admin.index')->with('success', 'Sorteo creado y tickets generados correctamente.');
    }

    public function edit(Sorteo $sorteo)
    {
        $sorteo->load('paquetes');
        return view('admin.edit', compact('sorteo'));
    }

    public function update(Request $request, Sorteo $sorteo)
    {
        $section = $request->input('_section');

        DB::transaction(function () use ($request, $sorteo, $section) {
            // 1. Basic Info
            if (!$section || $section === 'general') {
                $data = $request->validate([
                    'titulo' => 'required|string|max:255',
                    'descripcion' => 'nullable|string',
                    'precio_ticket' => 'required|numeric',
                    'total_tickets' => 'required|integer|min:1',
                    'porcentaje_manual' => 'required|integer|min:0|max:100',
                ]);
                $data['activo'] = $request->has('activo');
                $data['proceso_manual'] = $request->has('proceso_manual');

                // Si cambió el total de tickets, eliminamos y regeneramos (CUIDADO: solo si no hay ventas)
                if ($sorteo->total_tickets != $data['total_tickets']) {
                    if ($sorteo->tickets()->where('available', false)->exists()) {
                        throw new \Exception("No se puede cambiar el total de tickets porque ya hay ventas realizadas.");
                    }
                    $sorteo->tickets()->delete();
                    $tickets = [];
                    for ($i = 0; $i < $data['total_tickets']; $i++) {
                        $tickets[] = [
                            'sorteo_id' => $sorteo->id,
                            'numero' => str_pad($i, 5, '0', STR_PAD_LEFT),
                            'available' => true,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];

                        if (count($tickets) >= 1000) {
                            Ticket::insert($tickets);
                            $tickets = [];
                        }
                    }
                    if (!empty($tickets)) {
                        Ticket::insert($tickets);
                    }
                }
                if ($request->hasFile('imagen')) {
                    $path = $request->file('imagen')->store('sorteos', 'public');
                    $data['imagen'] = $path;
                }

                $sorteo->update($data);
            }

            // 2. Premios
            if (!$section || $section === 'premios') {
                $premios = $request->input('premios', []);
                foreach ($premios as $i => $premio) {
                    if (isset($premio['prizes'][0])) {
                        $premios[$i]['prizes'] = is_array($premio['prizes']) && !isset($premio['prizes'][1])
                            ? array_map('trim', explode(',', $premio['prizes'][0]))
                            : $premio['prizes'];
                    }

                    if ($request->hasFile("premios.$i.imagen")) {
                        $path = $request->file("premios.$i.imagen")->store('premios', 'public');
                        $premios[$i]['imagen_url'] = '/storage/' . $path;
                    } else {
                        $premios[$i]['imagen_url'] = $premio['imagen_url_hidden'] ?? ($sorteo->premios[$i]['imagen_url'] ?? null);
                    }
                }
                $sorteo->update(['premios' => $premios]);
            }

            // 3. Paquetes (Stickers)
            if (!$section || $section === 'paquetes') {
                $sorteo->paquetes()->delete();
                if ($request->has('paquetes')) {
                    foreach ($request->input('paquetes') as $pkg) {
                        if (isset($pkg['cantidad']) && isset($pkg['precio'])) {
                            $sorteo->paquetes()->create([
                                'cantidad' => $pkg['cantidad'],
                                'precio' => $pkg['precio'],
                                'es_extra' => isset($pkg['es_extra']),
                            ]);
                        }
                    }
                }
            }

            // 4. Anticipados
            if (!$section || $section === 'anticipados') {
                $anticipadosInput = $request->input('numeros_anticipados', []);
                $anticipados = [];

                // Limpiar marcas previas
                $sorteo->tickets()->update([
                    'belongs_to_anticipated_prize' => false,
                    'anticipated_prize_name' => null
                ]);

                foreach ($anticipadosInput as $i => $item) {
                    $titulo = $item['titulo'];
                    $numeros = $item['numeros'] ?? [];
                    $numerosValidos = [];

                    foreach ($numeros as $num) {
                        if (empty($num))
                            continue;

                        // Formatear con ceros a la izquierda si es necesario (asumiendo 5 dígitos como en la generación)
                        $numFormatted = str_pad($num, 5, '0', STR_PAD_LEFT);

                        $ticket = $sorteo->tickets()->where('numero', $numFormatted)->first();
                        if ($ticket) {
                            $ticket->update([
                                'belongs_to_anticipated_prize' => true,
                                'anticipated_prize_name' => $titulo
                            ]);
                            $numerosValidos[] = $numFormatted;
                        }
                    }

                    if (!empty($titulo)) {
                        $anticipados[] = [
                            'titulo' => $titulo,
                            'numeros' => $numerosValidos
                        ];
                    }
                }
                $sorteo->update(['numeros_anticipados' => $anticipados]);
            }
        });

        return redirect()->back()->with('success', 'Cambios guardados correctamente.');
    }

    public function destroy(Sorteo $sorteo)
    {
        $sorteo->delete();
        return redirect()->route('admin.index')->with('success', 'Sorteo eliminado.');
    }

    public function searchTickets(Request $request, Sorteo $sorteo)
    {
        $query = $request->get('q', '');
        $page = $request->get('page', 1);
        $limit = 120; // Multiple of 3, 4, 6 for grid alignment
        $offset = ($page - 1) * $limit;

        $dbQuery = $sorteo->tickets()->orderBy('numero', 'asc');

        if (!empty($query)) {
            $dbQuery->where('numero', 'like', "%$query%");
        }

        $tickets = $dbQuery->offset($offset)
            ->limit($limit)
            ->get(['id', 'numero', 'available']);

        return response()->json($tickets);
    }
}
