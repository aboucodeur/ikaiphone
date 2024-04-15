<x-default>
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Nouvelle reduction</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('reduction.store') }}">
                @csrf

                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="r_nom" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="r_nom" name="r_nom"
                                value="{{ old('r_nom') }}" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="r_type" class="form-label">Type</label>
                            <select class="form-select" id="r_type" name="r_type">
                                <option value="rem" {{ old('r_type') == 'rem' ? 'selected' : '' }}>Remise</option>
                                <option value="rab" {{ old('r_type') == 'rab' ? 'selected' : '' }}>Rabais</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="r_pourcentage" class="form-label">Pourcentage</label>
                    <input type="number" class="form-control" id="r_pourcentage" name="r_pourcentage"
                        value="{{ old('r_pourcentage') }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Valider</button>
            </form>
        </div>
    </div>
</x-default>
