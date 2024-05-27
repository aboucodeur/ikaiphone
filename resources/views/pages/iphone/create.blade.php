<form method="POST" action="{{ route('iphone.store') }}">
    @csrf
    <div class="row">
        <div class="col-lg-3">
            <div class="mb-3">
                {{-- <label for="i_barcode" class="form-label">CODE-BARRES</label> --}}
                <input autofocus onkeypress="return (event.key!='Enter')" type="text" class="form-control" id="i_barcode"
                    name="i_barcode" value="{{ old('i_barcode') }}" placeholder="IMEI DE L'IPHONE" required>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="mb-3">
                {{-- <label for="m_id" class="form-label">MODELE</label> --}}
                <select class="form-select" id="m_id" name="m_id" required>
                    <option value="">Sélectionner un modèle</option>
                    @foreach ($modeles as $modele)
                        <option value="{{ $modele->m_id }}">{{ $modele->m_nom }} {{ $modele->m_type }} ~
                            {{ $modele->m_memoire }} GO</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-lg-3">
            <button type="submit" class="btn btn-secondary w-100">Valider</button>
        </div>

    </div>
</form>
