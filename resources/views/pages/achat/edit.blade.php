<x-default dstyle="background: url('/achats.jpg')">
    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Modification achat</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('achat.update', $achat) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="a_date" class="form-label">Date</label>
                            <input type="date" class="form-control" name="a_date" id="a_date"
                                value="{{ old('a_date', date('d/m/Y')) }}" required />
                        </div>

                        <div class="mb-3">
                            <label for="f_id" class="form-label">Fournisseurs</label>
                            <select class="form-select" id="f_id" name="f_id" required>
                                <option value="">Sélectionner un fournisseur</option>
                                @foreach ($frs as $fr)
                                    <option value="{{ $fr->f_id }}"
                                        {{ $achat->f_id == $fr->f_id ? 'selected' : '' }}>
                                        {{ $fr->f_nom }}</option>
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
