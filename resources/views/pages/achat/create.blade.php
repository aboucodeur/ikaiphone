<x-default dstyle="background: url('/achats.jpg')">
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Nouveaux achat</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('achat.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="a_date" class="form-label">Date</label>
                    <input type="date" class="form-control" name="a_date" id="a_date"
                        value="{{ old('a_date', date('Y-m-d')) }}" required />
                </div>

                <div class="mb-3">
                    <label for="f_id" class="form-label">Fournisseur</label>
                    <select class="form-select" id="f_id" name="f_id" required>
                        <option value="">Sélectionner un fournisseur</option>
                        @foreach ($frs as $fr)
                            <option value="{{ $fr->f_id }}">{{ $fr->f_nom }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Valider</button>
            </form>
        </div>
    </div>
</x-default>
