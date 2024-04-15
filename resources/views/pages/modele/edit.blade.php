<x-default>
    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0 text-center text-primary">MODIFICATION MODELE</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('modele.update', $modele) }}">
                        @csrf
                        @method('PUT')


                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="m_nom" class="form-label">NOM</label>
                                    <input autofocus type="text" class="form-control" id="m_nom" name="m_nom"
                                        value="{{ old('m_nom', $modele->m_nom) }}" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">COULEUR</label>
                                    <select class="form-select form-select-lg" name="m_couleur" id="m_couleur" required>
                                        <option selected>Choisir le couleur</option>
                                        <option {{ $modele->m_couleur = 'Bleu' ? 'selected' : '' }} value="Bleu"
                                            class="text-primary">Bleu</option>
                                        <option {{ $modele->m_couleur = 'Noir' ? 'selected' : '' }} value="Noir">Noir
                                        </option>
                                        <option {{ $modele->m_couleur = 'Orange' ? 'selected' : '' }} value="Orange"
                                            class="text-warning">Orange</option>
                                        <option {{ $modele->m_couleur = 'Rouge' ? 'selected' : '' }} value="Rouge"
                                            class="text-danger">Rouge</option>
                                        <option {{ $modele->m_couleur = 'Vert' ? 'selected' : '' }} value="Vert"
                                            class="text-success">Vert</option>
                                        <option {{ $modele->m_couleur = 'Violet' ? 'selected' : '' }} value="Violet"
                                            style="color:violet;">Violet</option>
                                        <option {{ $modele->m_couleur = 'Blanc' ? 'selected' : '' }} value="Blanc"
                                            style="color:white;">Blanc</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="m_type" class="form-label">TYPE</label>
                                    <input type="text" class="form-control" id="m_type" name="m_type"
                                        value="{{ old('m_type', $modele->m_type) }}" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="m_memoire" class="form-label">MEMOIRE</label>
                                    <input type="number" class="form-control" id="m_memoire" name="m_memoire"
                                        value="{{ old('m_memoire', $modele->m_memoire) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="m_prix" class="form-label">PRIX</label>
                                    <input type="number" class="form-control" id="m_prix" name="m_prix"
                                        value="{{ old('m_prix', $modele->m_prix) }}" required>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Valider</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-3"></div>
    </div>
</x-default>
