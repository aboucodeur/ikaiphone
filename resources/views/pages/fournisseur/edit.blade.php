<x-default>
    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0 text-center text-primary">MODIFICATION FOURNISSEUR</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('fournisseur.update', $fournisseur) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="f_nom" class="form-label">NOM</label>
                            <input autofocus type="text" class="form-control" id="f_nom" name="f_nom"
                                value="{{ old('f_nom', $fournisseur->f_nom) }}" maxlength="100" required>
                        </div>

                        <div class="mb-3">
                            <label for="f_tel" class="form-label">TELEPHONE</label>
                            <input type="text" class="form-control" id="f_tel" name="f_tel"
                                value="{{ old('f_tel', $fournisseur->f_tel) }}" maxlength="25" required>
                        </div>

                        <div class="mb-3">
                            <label for="f_adr" class="form-label">ADRESSE</label>
                            <input type="text" class="form-control" id="f_adr" name="f_adr"
                                value="{{ old('f_adr', $fournisseur->f_adr) }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">VALIDER</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-3"></div>
    </div>
</x-default>
