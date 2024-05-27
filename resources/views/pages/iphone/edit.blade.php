<div class="row">
    <div class="mb-3">
        <label for="i_barcode" class="form-label">CODE-BARRES</label>
        <input autofocus type="text" class="form-control" id="i_barcode" name="i_barcode" value="{{ old('i_barcode') }}"
            required>
    </div>

    <div class="mb-3">
        <label for="m_id" class="form-label">MODELE</label>
        <select class="form-select" id="m_id" name="m_id" required>
            <option value="">Sélectionner un modèle</option>
            @foreach ($modeles as $modele)
                <option value="{{ $modele->m_id }}">
                    {{ $modele->m_nom }} {{ $modele->m_type }} ~ {{ $modele->m_memoire }} GO
                </option>
            @endforeach
        </select>
    </div>
</div>
