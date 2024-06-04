<x-default
    dstyle="background:url('/pos.jpg');background-repeat: no-repeat;background-attachment: fixed;background-position: center;">
    <div class="container">
        <div class="row">
            {{-- Formulaire & Panier --}}
            <div class="col-md-8">
                @yield('fpanier')
                @yield('panier')
            </div>
            {{-- Informations --}}
            <div class="col-md-4">
                @yield('ipanier')
            </div>
        </div>
    </div>

    <!-- MODALS / ECHANGE -->
    @extends('includes.modal', [
        'id' => 'addEchange',
        'fid' => 'faddEchange',
        'title' => 'Echanger l\'iphone',
        'fmethod' => 'PUT',
        'faction' => route('retour.store'),
        'b2Type' => 'submit',
    ])
    @section('content_addEchange')
        @include('pages.retour.create')
    @endsection

</x-default>

{{-- SCRIPT ECHANGE --}}
<script>
    $(function() {
        $(".addEchangeBtn").on("click", function() {
            var route = $(this).data('route');
            var i_id = $(this).data('i_id');
            var type = $(this).data('type');
            var form = $('#faddEchange');
            form.attr('action', route);

            // append i_id and type to form with jquery
            $("#faddEchange").append(`<input type="hidden" name="i_id" value="${i_id}">`);
            $("#faddEchange").append(`<input type="hidden" name="type" value="${type}">`);

            setTimeout(() => {
                form.find('#ip_ech_id').focus();
            }, 1000);
        })
    })
</script>

@isset($run_script)
    <script>
        /**
         * Implementation de la logique d'insertion grouper
         * choisir le modele puis le stocker en localstorage
         * choisir la quantite a charger
         * choisir le prix
         * choisir le code-barres
         * **/
        $(function() {
            // Initialisation des valeurs à partir du localStorage
            let m_id = localStorage.getItem('m_id');
            let quantite = localStorage.getItem('quantite');
            let chargeQte = quantite ? parseInt(quantite, 10) : 0;

            // Mise à jour des champs avec les valeurs du localStorage
            if (m_id) $('#m_id').val(m_id);
            if (quantite) $('#quantite').val(chargeQte);

            // Gestion des changements sur les champs pour mise à jour du localStorage
            $('#m_id, #quantite').change(function() {
                localStorage.setItem('m_id', $('#m_id').val());
                localStorage.setItem('quantite', $('#quantite').val());
                chargeQte = parseInt($('#quantite').val(), 10);
            });

            // Validation de la quantité lors de la soumission du formulaire
            $('form').submit(function(e) {
                if (chargeQte > 0) {
                    chargeQte--;
                    $('#quantite').val(chargeQte);
                    localStorage.setItem('quantite', chargeQte.toString());
                }
            });
        });
    </script>
@endisset
