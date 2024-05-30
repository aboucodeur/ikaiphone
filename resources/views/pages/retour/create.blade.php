@php
    $current_date = date('Y-m-d');
@endphp

<div class="row">
    <div class="row">
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="re_date" class="form-label">Date (*)</label>
                <input required type="date" class="form-control" id="re_date" name="re_date"
                    value="{{ old('re_date', $current_date) }}">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="re_motif" class="form-label">Motif</label>
                <input placeholder="Ex : Batterie pourcentage" type="text" class="form-control" id="re_motif"
                    name="re_motif" value="{{ old('re_motif') }}">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="barcode" class="form-label">Iphone Retourné (*)</label>
                <input required onkeypress="return (event.key!='Enter')" autofocus type="text" class="form-control"
                    name="barcode" id="barcode" aria-describedby="helpId" placeholder="Code bare" />
                <button type="submit" autofocus="false" class="btn btn-sm btn-warning w-100 text-white fw-bold mt-3"
                    hx-get="{{ route('retour.checkIphone') }}" hx-target="#info_retour" hx-trigger="click"
                    hx-include="[name='barcode']" hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'>
                    VERIFIER IMEI
                    <i class="bi bi-upc-scan"></i>
                </button>
                <div id="info_retour"></div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="i_ech_id" class="form-label">Nouvel iPhone (*)</label>
                <input required onkeypress="return (event.key!='Enter')" autofocus type="text" class="form-control"
                    name="i_ech_id" id="i_ech_id" placeholder="Code IMEI">
                <button type="submit" class="btn btn-sm btn-primary w-100 text-white fw-bold mt-3"
                    hx-get="{{ route('retour.checkIphone') }}" hx-target="#info_iphone" hx-trigger="click"
                    hx-include="[name='i_ech_id']" hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'>
                    VERIFIER IMEI
                    <i class="bi bi-upc-scan"></i>
                </button>
                <div id="info_iphone"></div>
            </div>
        </div>
    </div>
</div>
