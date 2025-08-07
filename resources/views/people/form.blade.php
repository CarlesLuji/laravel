<div class="mb-3">
  <label for="Persona" class="form-label">Persona</label>
  <input type="text" name="Persona" class="form-control" value="{{ old('Persona', $person->Persona ?? '') }}">
</div>

<div class="mb-3">
  <label for="Nivel" class="form-label">Nivel</label>
  <input type="number" name="Nivel" class="form-control" value="{{ old('Nivel', $person->Nivel ?? 4) }}">
</div>

<div class="mb-3">
  <label for="Dpto" class="form-label">Departamento</label>
  <input type="text" name="Dpto" class="form-control" value="{{ old('Dpto', $person->Dpto ?? '') }}">
</div>
