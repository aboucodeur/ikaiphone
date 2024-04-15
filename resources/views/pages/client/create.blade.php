<x-default>
    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0 text-primary text-center">NOUVEAUX CLIENTS / REVENDEURS</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('client.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="c_nom" class="form-label">Nom</label>
                            <input autofocus type="text" class="form-control" id="c_nom" name="c_nom"
                                value="{{ old('c_nom') }}" minlength="2" maxlength="100" required>
                        </div>

                        <div class="mb-3">
                            <label for="c_tel" class="form-label">Téléphone</label>
                            <input type="text" class="form-control" id="c_tel" name="c_tel"
                                value="{{ old('c_tel') }}" minlength="10" maxlength="25" required>
                        </div>

                        <div class="mb-3">
                            <label for="c_adr" class="form-label">Adresse</label>
                            <input type="text" class="form-control" id="c_adr" name="c_adr"
                                value="{{ old('c_adr') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="c_type" class="form-label">Type</label>
                            <select class="form-select" id="c_type" name="c_type" required>
                                <option value="SIMPLE" {{ old('c_type') == 'SIMPLE' ? 'selected' : '' }}>Simple
                                </option>
                                <option value="REVENDEUR" {{ old('c_type') == 'REVENDEUR' ? 'selected' : '' }}>Revendeur
                                </option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Valider</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-3"></div>
    </div>
</x-default>
