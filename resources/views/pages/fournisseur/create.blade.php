<div class="row">
    <div class="mb-3">
        <label for="f_nom" class="form-label">Nom (*)</label>
        <input autofocus type="text" class="form-control" id="f_nom" name="f_nom" value="{{ old('f_nom') }}"
            maxlength="100" required placeholder="Nom du fournisseur">
    </div>

    <div class="mb-3">
        <label for="f_tel" class="form-label">Téléphone</label>
        <input type="text" class="form-control" id="f_tel" name="f_tel" value="{{ old('f_tel') }}"
            maxlength="25" placeholder="+223 94 86 58 79">
    </div>

    <div class="mb-3">
        <label for="f_adr" class="form-label">Adresse</label>
        <input type="text" class="form-control" id="f_adr" name="f_adr" value="{{ old('f_adr') }}"
            placeholder="Halle de Bamako">
    </div>
</div>
