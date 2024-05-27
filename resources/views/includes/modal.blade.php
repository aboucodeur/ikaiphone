{{-- Amelioration du composant modal qu --}}
@props([
    'title' => 'Modal title', // titre du modal
    'id' => '', // id du modal
    'class' => '', // class du modal
    'mclass' => '',
    'b2Type' => '',

    'fid' => '', // append un formulaire dans le modal pour faciliter le crud avec javascript
    'fmethod' => '', // methode du formulaire
    'faction' => '', // action du formulaire
])

<div class="modal fade {{ $class }}" id="{{ $id }}" tabindex="-1" role="dialog"
    aria-labelledby="{{ 'modalTitle' . $id }}" aria-hidden="true">
    <div class="modal-dialog {{ $mclass ?? 'modal-dialog-scrollable modal-dialog-centered modal-sm' }}" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center text-success">{{ Str::upper($title) }}</h5>
            </div>

            @if ($fid)
                <form id="{{ $fid }}" method="POST" action="{{ $faction }}">
                    @csrf
                    {{-- POUR PUT / DELETE --}}
                    @if (isset($fmethod) && $fmethod !== 'POST')
                        @method($fmethod)
                    @endif
            @endif

            <div class="modal-body">@yield('content_' . $id)</div>
            <div class="modal-footer">
                @if (!empty(trim($__env->yieldContent('footer_' . $id))))
                    @yield('footer_' . $id)
                @else
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">FERMER</button>
                    <button type="{{ $b2Type ?? 'button' }}" class="btn btn-success">VALIDER</button>
                @endif
            </div>

            @if ($fid)
                </form>
            @endif
        </div>
    </div>
</div>
