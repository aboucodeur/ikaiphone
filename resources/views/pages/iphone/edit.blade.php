<x-default dstyle="background: url('/iphones.jpg');">
    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0 text-center text-primary">MODIFICATION IPHONE</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('iphone.update', $iphone) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="i_barcode" class="form-label">CODE-BARRES</label>
                            <input autofocus type="text" class="form-control" id="i_barcode" name="i_barcode"
                                value="{{ old('i_barcode', $iphone->i_barcode) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="m_id" class="form-label">MODELE</label>
                            <select class="form-select" id="m_id" name="m_id" required>
                                <option value="">Sélectionner un modèle</option>
                                @foreach ($modeles as $modele)
                                    <option value="{{ $modele->m_id }}"
                                        {{ $modele->m_id == $iphone->m_id ? 'selected' : '' }}>
                                        {{ $modele->m_nom }} {{ $modele->m_type }} ~ {{ $modele->m_memoire }} GO
                                    </option>
                                @endforeach
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
