<x-default>
    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Modification vente</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('vendre.update', $vendre) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="v_date" class="form-label">Date</label>
                            <input type="date" class="form-control" name="v_date" id="v_date"
                                value="{{ old('v_date', date('Y-m-d')) }}" required />
                        </div>

                        <div class="mb-3">
                            <label for="c_id" class="form-label">Clients</label>
                            <select class="form-select" id="c_id" name="c_id" required>
                                <option value="">Sélectionner un client</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->c_id }}"
                                        {{ $vendre->c_id == $client->c_id ? 'selected' : '' }}>
                                        {{ $client->c_nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Valider</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-3"></div>
    </div>
</x-default>
