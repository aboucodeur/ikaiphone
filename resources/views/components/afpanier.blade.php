@props(['route' => '#', 'iphones', 'modeles' => []])

<!-- Formulaire d'ajout -->
<div class="card mb-4">
    <div class="card-body">
        <form method="POST" action="{{ $route }}">
            @csrf
            <div class="row">

                {{-- Modele --}}
                <div class="col-lg-3">
                    <div class="mb-3">
                        <label for="m_id" class="form-label">Modèle</label>
                        <select class="form-select" id="m_id" name="m_id" required>
                            <option value="">Sélectionner un modèle</option>
                            @foreach ($modeles as $modele)
                                <option value="{{ $modele->m_id }}">{{ $modele->m_nom }} {{ $modele->m_type }} ~
                                    {{ $modele->m_memoire }} (GO) / PV :
                                    {{ number_format($modele->m_prix, 0, '', ' ') }} F
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Quantite --}}
                <div class="col-lg-2">
                    <div class="mb-3">
                        <label for="quantite" class="form-label">QTE</label>
                        <input min="0" max="10000" type="number" class="form-control" id="quantite"
                            name="quantite" required placeholder="CHARGE" value="0">
                    </div>
                </div>

                {{-- Prix --}}
                <div class="col-lg-3">
                    <div class="mb-3">
                        <label for="s_iphone_prix" class="form-label">Prix</label>
                        <input type="number" class="form-control" id="s_iphone_prix" name="prix" required
                            placeholder="Prix d'achat" value="0">
                    </div>
                </div>

                {{-- Code barres (Prevenir l'auto submit du scanneur) --}}
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label for="i_barcode" class="form-label">Code-barres</label>
                        <input onkeypress="return (event.key!='Enter')" autofocus type="text" class="form-control"
                            id="i_barcode" name="i_barcode" value="{{ old('i_barcode') }}" required
                            placeholder="code_bare ici">
                    </div>
                </div>

                <div class="col-lg-3 mt-">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-arrow-down-circle-fill" style="font-size: 1rem"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
