<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PersonController extends Controller
{
    use AuthorizesRequests;

    /**
     * Listado de personas
     */
    public function index()
    {
        $this->authorize('ver people');

        $people = Person::all();

        return view('people.index', compact('people'));
    }

    /**
     * Formulario de creación
     */
    public function create()
    {
        $this->authorize('crear people');

        return view('people.create');
    }

    /**
     * Guardar nueva persona
     */
    public function store(Request $request)
    {
        $this->authorize('crear people');

        $validated = $request->validate([
            'Persona' => 'required|string|max:50',
            'Nivel'   => 'nullable|integer',
            'Dpto'    => 'nullable|string|max:50',
        ]);

        Person::create($validated);

        return redirect()->route('people.index')
            ->with('success', 'Persona creada correctamente.');
    }

    /**
     * Formulario de edición
     */
    public function edit(Person $person)
    {
        $this->authorize('editar people');

        return view('people.edit', compact('person'));
    }

    /**
     * Actualizar persona
     */
    public function update(Request $request, Person $person)
    {
        $this->authorize('editar people');

        $validated = $request->validate([
            'Persona' => 'required|string|max:50',
            'Nivel'   => 'nullable|integer',
            'Dpto'    => 'nullable|string|max:50',
        ]);

        $person->update($validated);

        return redirect()->route('people.index')
            ->with('success', 'Persona actualizada correctamente.');
    }

    /**
     * Eliminar persona
     */
    public function destroy(Person $person)
    {
        $this->authorize('eliminar people');

        $person->delete();

        return redirect()->route('people.index')
            ->with('success', 'Persona eliminada correctamente.');
    }
}

