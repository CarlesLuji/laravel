<?php

namespace App\Http\Controllers;

use App\Models\Rdor;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RdorController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('ver rdors');

        $rdors = Rdor::all();
        return view('rdors.index', compact('rdors'));
    }

    public function create()
    {
        $this->authorize('crear rdors');

        return view('rdors.create');
    }

    public function store(Request $request)
    {
        $this->authorize('crear rdors');

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:50',
        ]);

        Rdor::create($validated);

        return redirect()->route('rdors.index')->with('success', 'Rdor creado correctamente.');
    }

    public function edit(Rdor $rdor)
    {
        $this->authorize('editar rdors');

        return view('rdors.edit', compact('rdor'));
    }

    public function update(Request $request, Rdor $rdor)
    {
        $this->authorize('editar rdors');

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:50',
        ]);

        $rdor->update($validated);

        return redirect()->route('rdors.index')->with('success', 'Rdor actualizado correctamente.');
    }

    public function destroy(Rdor $rdor)
    {
        $this->authorize('eliminar rdors');

        $rdor->delete();

        return redirect()->route('rdors.index')->with('success', 'Rdor eliminado correctamente.');
    }
}
