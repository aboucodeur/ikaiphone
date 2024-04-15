<form method="POST" action="{{ route('vendre.store') }}">
    @csrf
    <div class="row">
        <div class="col-lg-3">
            <div class="mb-3">
                <input type="date" class="form-control" name="v_date" id="v_date"
                    value="{{ old('v_date', date('Y-m-d')) }}" required />
            </div>
        </div>
        <div class="col-lg-6">
            <div class="mb-3">
                <select class="form-select" id="c_id" name="c_id" required>
                    <option value="">Sélectionner un client</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->c_id }}">{{ Str::upper($client->c_nom) }} ~
                            {{ $client->c_type }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-3">
            <button type="submit" class="btn btn-secondary w-100">Valider</button>
        </div>
    </div>
</form>
