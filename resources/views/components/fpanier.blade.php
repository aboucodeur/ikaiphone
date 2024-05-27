@props(['route' => '#', 'iphones', 'datasiphones'])

<!-- Formulaire d'ajout -->
<div class="card mb-4">
    <div class="card-body">
        <form method="POST" action="{{ $route }}">
            @csrf

            <input type="hidden" name="" id="datas_iphones_ventes"
                data-datas_iphones_ventes="{{ json_encode($datasiphones) }}">

            <div class="row">
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label for="vbarcode" class="form-label">Scanner</label>
                        <input onkeypress="return (event.key!='Enter')" autofocus type="text" class="form-control"
                            name="vbarcode" id="vbarcode" aria-describedby="helpId" placeholder="Code bare" />
                        <button autofocus="false" type="button" id="valid_vente_btn" type="button"
                            class="btn btn-sm btn-warning text-white fw-bold mt-2">
                            Valider le code <i class="bi bi-upc-scan"></i>
                        </button>
                        <div id="info_vente"></div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="mb-3">
                        <label for="s_iphone_prix" class="form-label">Prix</label>
                        <input type="number" class="form-control" id="s_iphone_prix" name="prix" required>
                    </div>
                </div>

                <div class="col-lg-5 mt-4">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-arrow-down-circle-fill" style="font-size: 2rem"></i>
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>
