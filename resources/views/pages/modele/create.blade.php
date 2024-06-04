<div class="row">
    <div class="col-lg-6">
        <div class="mb-3">
            <label for="m_nom" class="form-label">NOM (*)</label>
            <input autofocus type="text" class="form-control" id="m_nom" name="m_nom"
                value="{{ old('m_nom', 'iPhone ') }}" required>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-3">
            <label for="m_type" class="form-label">Type (*)</label>
            <select required class="form-select form-select-lg" name="m_type" id="m_type">
                <option selected>Choisir le type</option>
                @foreach ($types_iphones as $t)
                    <option value="{{ $t }}">{{ $t }}</option>
                @endforeach
            </select>
            @error('m_type')
                <span class="invalid-feedback">
                    Type invalide
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="mb-3">
            <label for="m_memoire" class="form-label">MEMOIRE (*)</label>
            <input type="number" class="form-control @error('m_memoire') is-invalid @enderror" id="m_memoire"
                name="m_memoire" value="{{ old('m_memoire', 128) }}" required>
            @error('m_memoire')
                <span class="invalid-feedback">
                    Memoire invalide
                </span>
            @enderror
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-3">
            <label for="m_prix" class="form-label">PRIX (*)</label>
            <input type="number" class="form-control  @error('m_prix') is-invalid @enderror" id="m_prix"
                name="m_prix" value="{{ old('m_prix', 0) }}" required>
            @error('m_prix')
                <span class="invalid-feedback">
                    Memoire invalide
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <label for="f_id" class="form-label">Fournisseur</label>
        <select name="f_id" id="f_id" class="form-select">
            <option value="" selected>Choisir le fournisseur</option>
            @foreach ($fournisseurs as $f)
                <option value="{{ $f->f_id }}">{{ $f->f_nom }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-lg-12">
        <div class="mb-3">
            <label for="m_ids" class="form-label" id="label_m_ids">Description ! (0 scannés)</label>
            <textarea placeholder="Scanner les iphones " minlength="8" onkeypress="return (event.key!='Enter')"
                class="form-control" name="m_ids" id="m_ids" rows="4" oninput="updateCount()"></textarea>
        </div>
    </div>
</div>
<script>
    function updateCount() {
        const textarea = document.getElementById('m_ids');
        const codes = textarea.value.split(';').filter(code => /^[a-zA-Z0-9]+$/.test(code.trim()));
        const count = codes.length;
        const label = document.getElementById('label_m_ids');
        label.textContent = `Description ! (${count} scannés)`;
    }
</script>
