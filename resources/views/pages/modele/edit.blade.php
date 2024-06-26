<div class="row">
    <div class="col-lg-12">
        <div class="mb-3">
            <label for="m_nom" class="form-label">NOM</label>
            <input autofocus type="text" class="form-control" id="m_nom" name="m_nom" value="{{ old('m_nom') }}"
                required>

        </div>
    </div>


    <div class="col-lg-6">
        <div class="mb-3">
            <label for="m_type" class="form-label">Type (*)</label>
            {{-- mettre a jour pour prendre en compte la old --}}
            <select required class="form-select form-select-lg" name="m_type" id="m_type">
                <option selected>Choisir le type</option>
                @foreach ($types_iphones as $t)
                    <option {{ old('m_type') == $t ? 'selected' : '' }} value="{{ $t }}">
                        {{ $t }}</option>
                @endforeach
            </select>
            @error('m_type')
                <span class="invalid-feedback">
                    Type invalide
                </span>
            @enderror
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-3">
            <label for="m_memoire" class="form-label">MEMOIRE (*)</label>
            <input type="number" class="form-control @error('m_memoire') is-invalid @enderror" id="m_memoire"
                name="m_memoire" value="{{ old('m_memoire') }}" required>
            @error('m_memoire')
                <span class="invalid-feedback">
                    Memoire invalide
                </span>
            @enderror
        </div>
    </div>


    <div class="col-lg-12">
        <div class="mb-3">
            <label for="m_prix" class="form-label">PRIX</label>
            <input type="number" class="form-control @error('m_prix') is-invalide @enderror" id="m_prix"
                name="m_prix" value="{{ old('m_prix') }}" required>
            @error('m_prix')
                <span class="invalid-feedback">
                    Prix invalide
                </span>
            @enderror
        </div>
    </div>
</div>
