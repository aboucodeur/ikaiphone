<!-- Sidebar -->
<div class="navbar-vertical navbar nav-dashboard bg-success ">
    <div class="h-100" data-simplebar>
        <!-- Navbar nav -->
        <ul class="navbar-nav gap-0 md-0 flex-column text-right mt-5" id="sideNavbar">
            {{-- <x-menutitle title="STOCKS" /> --}}

            @if (auth()->user()->u_type === 'admin')
                <x-menu title="{{ Str::upper('Tableaux') }}" url="/">
                    {{-- <x-iicon src="/assets/icons/stats.png" alt="stats" /> --}}
                    <img width="25px" class="m-1" src="/assets/images/svg/stockchart.svg" alt="dashboard">
                </x-menu>

                <x-menu title="{{ Str::upper('STOCKS') }}" url="/modele">
                    {{-- <x-iicon src="/assets/icons/modele.png" alt="modele" /> --}}
                    <img width="25px" class="m-1" src="/assets/images/svg/layers.svg" alt="modeles">
                </x-menu>

                <x-menutitle title="{{ Str::upper('ENTREES') }}" />

                <x-menu title="{{ Str::upper('Fournisseur') }}" url="/fournisseur">
                    {{-- <x-iicon src="/assets/icons/frs.png" alt="fournisseur" /> --}}
                    <img width="25px" class="m-1" src="/assets/images/svg/delivery-truck.svg" alt="fournisseur">
                </x-menu>

                <x-menu title="{{ Str::upper('Str')::upper('(Arrivages) Achats') }}" url="/achat">
                    {{-- <x-iicon src="/assets/icons/achat.png" alt="achat" /> --}}
                    <img width="25px" class="m-1" src="/assets/images/svg/airplane.svg" alt="achats">
                </x-menu>

                <x-menutitle title="{{ Str::upper('Autres') }}" />

                <x-menu title="{{ Str::upper('Utilisateurs') }}" url="/user">
                    {{-- <x-iicon src="/assets/icons/user.png" alt="utilisateur" /> --}}
                    <img width="25px" class="m-1" src="/assets/images/svg/user.svg" alt="utilisateur">
                </x-menu>
            @endif

            @if (auth()->user()->u_type === 'user' || auth()->user()->u_type === 'admin')
                <x-menutitle title="{{ Str::upper('SORTIES') }}" />

                <x-menu title="{{ Str::upper('Clients') }}" url="/client">
                    <x-iicon src="/assets/icons/clients.png" alt="clients" />
                </x-menu>

                <x-menu title="{{ Str::upper('Ventes') }}" url="/vendre">
                    {{-- <x-iicon src="/assets/icons/ventes.png" alt="ventes" /> --}}
                    <img width="25px" class="m-1" src="/assets/images/svg/shopping-cart.svg" alt="ventes">
                </x-menu>

                <x-menu title="{{ Str::upper('Retour') }}" url="/retour">
                    {{-- <i class="bi bi-arrow-clockwise"></i> --}}
                    <img src="/assets/images/svg/undo-2.svg" alt="Undo icon">&nbsp;
                </x-menu>
            @endif
        </ul>
    </div>
</div>
