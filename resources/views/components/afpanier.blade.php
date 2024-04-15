@props(['route' => '#', 'iphones', 'modeles' => []])

<!-- Formulaire d'ajout -->
<div class="card mb-4">
    <div class="card-body">
        <form method="POST" action="{{ $route }}">
            @csrf
            <div class="row">
                <div class="col-lg-3">
                    <div class="mb-3">
                        <label for="i_barcode" class="form-label">Code-barres</label>
                        <input autofocus type="text" class="form-control" id="i_barcode" name="i_barcode"
                            value="{{ old('i_barcode') }}" required placeholder="code_bare ici">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="mb-3">
                        <label for="m_id" class="form-label">Modèle</label>
                        <select class="form-select" id="m_id" name="m_id" required>
                            <option value="">Sélectionner un modèle</option>
                            @foreach ($modeles as $modele)
                                <option value="{{ $modele->m_id }}">{{ $modele->m_nom }} {{ $modele->m_type }} ~
                                    {{ $modele->m_memoire }} (GO)</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="mb-3">
                        <label for="s_iphone_prix" class="form-label">Prix</label>
                        <input type="number" class="form-control" id="s_iphone_prix" name="prix" required
                            placeholder="Prix d'achat">
                    </div>
                </div>
                <div class="col-lg-3 mt-4">
                    <button type="submit" class="btn btn-primary w-100">
                        {{-- <i class="bi bi-plus-circle-fill"></i> --}}
                        {{-- <strong>Ajouter</strong> --}}
                        <i class="bi bi-arrow-down-circle-fill" style="font-size: 2rem"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
