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
</x-default>
