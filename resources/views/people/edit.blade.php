@extends('layouts.adminlte')

@section('content')<p>
<div class="container-fluid">
  <h1 class="h3 mb-3">Editar Persona</h1>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('people.update', $person) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
          <div class="col-md-4 mb-3">
            <label for="Persona" class="form-label">Nombre</label>
            <input type="text" name="Persona" id="Persona" value="{{ old('Persona', $person->Persona) }}" class="form-control @error('Persona') is-invalid @enderror" required>
            @error('Persona') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
          <div class="col-md-4 mb-3">
            <label for="Nivel" class="form-label">Nivel</label>
            <input type="number" name="Nivel" id="Nivel" value="{{ old('Nivel', $person->Nivel) }}" class="form-control @error('Nivel') is-invalid @enderror" required>
            @error('Nivel') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
          <div class="col-md-4 mb-3">
            <label for="Dpto" class="form-label">Departamento</label>
            <input type="text" name="Dpto" id="Dpto" value="{{ old('Dpto', $person->Dpto) }}" class="form-control @error('Dpto') is-invalid @enderror">
            @error('Dpto') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
        </div>
        <div class="mt-3">
          <button class="btn btn-danger">Actualizar</button>
          <a href="{{ route('people.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
