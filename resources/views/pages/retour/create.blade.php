@php
    $current_date = date('Y-m-d');
@endphp

<div class="row">
    <input type="hidden" name="" id="datas_iphones" data-datas_iphones="{{ json_encode($datas_iphones) }}">

    <div class="row">
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="re_date" class="form-label">Date</label>
                <input type="date" class="form-control" id="re_date" name="re_date"
                    value="{{ old('re_date', $current_date) }}" required>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="re_motif" class="form-label">Motif</label>
                <input type="text" class="form-control" id="re_motif" name="re_motif" value="{{ old('re_motif') }}">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="barcode" class="form-label">Iphone Retourné</label>
                <input onkeypress="return (event.key!='Enter')" autofocus type="text" class="form-control"
                    name="barcode" id="barcode" aria-describedby="helpId" placeholder="Code bare" />
                <button autofocus="false" type="button" id="valid_retour_btn" type="button"
                    class="btn btn-sm btn-warning text-white fw-bold mt-3">
                    Valider le code <i class="bi bi-upc-scan"></i>
                </button>
                <div id="info_retour"></div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="i_ech_id" class="form-label">Nouvel iPhone</label>
                <input onkeypress="return (event.key!='Enter')" autofocus type="text" class="form-control"
                    name="i_ech_id" id="i_ech_id" placeholder="" />
            </div>
        </div>
    </div>
</div>
