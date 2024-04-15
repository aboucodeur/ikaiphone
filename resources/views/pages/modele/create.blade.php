<x-default>
    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0 text-center text-primary">NOUVEAUX MODELE</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('modele.store') }}">
                        @csrf

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="m_nom" class="form-label">NOM</label>
                                    <input autofocus type="text" class="form-control" id="m_nom" name="m_nom"
                                        value="{{ old('m_nom', 'iPhone ...') }}" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">COULEUR</label>
                                    <select class="form-select form-select-lg" name="m_couleur" id="m_couleur" required>
                                        <option selected>Choisir le couleur</option>
                                        <option value="Bleu" class="text-primary">Bleu</option>
                                        <option value="Noir">Noir</option>
                                        <option value="Orange" class="text-warning">Orange</option>
                                        <option value="Rouge" class="text-danger">Rouge</option>
                                        <option value="Vert" class="text-success">Vert</option>
                                        <option value="Violet" style="color:violet;">Violet</option>
                                        <option value="Blanc" style="color:white;">Blanc</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="m_type" class="form-label">TYPE</label>
                                    <input type="text" class="form-control" id="m_type" name="m_type"
                                        value="{{ old('m_type', 'Simple') }}" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="m_memoire" class="form-label">MEMOIRE</label>
                                    <input type="number" class="form-control" id="m_memoire" name="m_memoire"
                                        value="{{ old('m_memoire', 128) }}" required>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="m_prix" class="form-label">PRIX</label>
                                    <input type="number" class="form-control" id="m_prix" name="m_prix"
                                        value="{{ old('m_prix', 0) }}" required>
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
