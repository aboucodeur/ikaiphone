<div class="row">
    <div class="mb-3">
        <label for="c_nom" class="form-label">Nom (*)</label>
        <input autofocus type="text" class="form-control" id="c_nom" name="c_nom" value="{{ old('c_nom') }}"
            minlength="2" maxlength="100" required>
    </div>

    <div class="mb-3">
        <label for="c_tel" class="form-label">Téléphone</label>
        <input type="text" class="form-control @error('c_tel') is-invalid @enderror" id="c_tel" name="c_tel"
            value="{{ old('c_tel') }}" minlength="10" maxlength="25">
        @error('c_tel')
            <span class="invalid-feedback" role="alert">
                Numero invalide
            </span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="c_adr" class="form-label">Adresse</label>
        <input type="text" class="form-control @error('c_adr') is-invalid @enderror" id="c_adr" name="c_adr"
            value="{{ old('c_adr') }}">
        @error('c_adr')
            <span class="invalid-feedback" role="alert">
                Adresse invalide
            </span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="c_type" class="form-label">Type (*)</label>
        <select class="form-select" id="c_type" name="c_type" required>
            <option value="SIMPLE" {{ old('c_type') == 'SIMPLE' ? 'selected' : '' }}>Simple</option>
            <option value="REVENDEUR" {{ old('c_type') == 'REVENDEUR' ? 'selected' : '' }}>
                Revendeur
            </option>
        </select>
    </div>
</div>
