<?php

namespace App\Http\Controllers;

use App\Models\Sorteo;
use App\Models\Paquete;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $sorteos = Sorteo::withCount('tickets')->get();
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
        ]);

        $data['activo'] = $request->has('activo');

        Sorteo::create($data);

        return redirect()->route('admin.index')->with('success', 'Sorteo creado correctamente.');
    }

    public function edit(Sorteo $sorteo)
    {
        return view('admin.edit', compact('sorteo'));
    }

    public function update(Request $request, Sorteo $sorteo)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio_ticket' => 'required|numeric',
            'total_tickets' => 'required|integer|min:1',
        ]);

        $data['activo'] = $request->has('activo');

        $sorteo->update($data);

        return redirect()->route('admin.index')->with('success', 'Sorteo actualizado correctamente.');
    }

    public function destroy(Sorteo $sorteo)
    {
        $sorteo->delete();
        return redirect()->route('admin.index')->with('success', 'Sorteo eliminado.');
    }
}
