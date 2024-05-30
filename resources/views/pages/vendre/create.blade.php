<form method="POST" action="{{ route('vendre.store') }}">
    @csrf
    <div class="row">
        <div class="col-lg-3">
            <div class="mb-3">
                <input type="date" class="form-control" name="v_date" id="v_date"
                    value="{{ old('v_date', date('Y-m-d')) }}" required />
            </div>
        </div>
        <div class="col-lg-3">
            <div class="input-group mb-3">
                <select autofocus class="form-select" id="c_id" name="c_id" required>
                    <option value="">Sélectionner un client</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->c_id }}">{{ Str::upper($client->c_nom) }} ~
                            {{ $client->c_type }}
                        </option>
                    @endforeach
                </select>
                <span class="input-group-text">
                    <img src="/assets/images/svg/user.svg" alt="Client financier icon">
                </span>
            </div>
        </div>
        <div class="col-lg-3">
            <button type="submit" class="btn btn-success w-100">
                {{-- image add svg icon --}}
                <img src="/assets/images/svg/package-check.svg" alt="Package check icon">
            </button>
        </div>
        <div class="col-lg-3">
            {{ \App\Helpers\ModalHelper::trigger('addClient', '<i class="bi bi-plus-circle-fill"></i> CLIENTS', 'btn btn-primary w-100') }}
        </div>
    </div>
</form>

@extends('includes.modal', [
    'id' => 'addClient',
    'fid' => 'faddClient',
    'title' => 'ACTION RAPIDE',
    'fmethod' => 'POST',
    'faction' => route('vendre.client.fast'),
    'b2Type' => 'submit',
])
@section('content_addClient')
    @include('pages.client.create')
@endsection
