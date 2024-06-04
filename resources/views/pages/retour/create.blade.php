@php
    $current_date = date('Y-m-d');
@endphp

<div class="row">
    <div class="col-lg-12">
        <div class="mb-3">
            <label for="ip_ech_desc" class="form-label">Motif</label>
            <input placeholder="Ex : Probleme de batterie" type="text" class="form-control" id="re_motif"
                name="ip_ech_desc" value="{{ old('ip_ech_desc') }}">
        </div>
    </div>
</div>

<div class="col-lg-12">
    <div class="mb-3">
        <label for="ip_ech_id" class="form-label">Nouvel iPhone (*)</label>
        <input required onkeypress="return (event.key!='Enter')" autofocus type="text" class="form-control"
            name="ip_ech_id" id="ip_ech_id" placeholder="Code IMEI">
    </div>
</div>
