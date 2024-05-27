<!-- Sidebar -->
<div class="navbar-vertical navbar nav-dashboard bg-success ">
    <div class="h-100" data-simplebar>
        <!-- Navbar nav -->
        <ul class="navbar-nav gap-0 md-0 flex-column text-right mt-5" id="sideNavbar">
            {{-- <x-menutitle title="STOCKS" /> --}}

            @if (auth()->user()->u_type === 'admin')
                <x-menu title="{{ Str::upper('Tableaux') }}" url="/">
                    <x-iicon src="/assets/icons/stats.png" alt="stats" />
                </x-menu>

                <x-menu title="{{ Str::upper('Modele') }}" url="/modele">
                    <x-iicon src="/assets/icons/modele.png" alt="modele" />
                </x-menu>

                <x-menu title="{{ Str::upper('Iphones') }}" url="/iphone">
                    <x-iicon src="/assets/icons/iphone.png" alt="iphone" />
                </x-menu>

                <x-menutitle title="{{ Str::upper('ENTREES') }}" />

                <x-menu title="{{ Str::upper('Fournisseur') }}" url="/fournisseur">
                    <x-iicon src="/assets/icons/frs.png" alt="fournisseur" />
                </x-menu>

                <x-menu title="{{ Str::upper('Str')::upper('(Arrivages) Achats') }}" url="/achat">
                    <x-iicon src="/assets/icons/achat.png" alt="achat" />
                </x-menu>

                <x-menutitle title="{{ Str::upper('Autres') }}" />

                <x-menu title="{{ Str::upper('Utilisateurs') }}" url="/user">
                    <x-iicon src="/assets/icons/user.png" alt="utilisateur" />
                </x-menu>
            @endif

            @if (auth()->user()->u_type === 'user' || auth()->user()->u_type === 'admin')
                <x-menutitle title="{{ Str::upper('SORTIES') }}" />

                <x-menu title="{{ Str::upper('Clients') }}" url="/client">
                    <x-iicon src="/assets/icons/clients.png" alt="clients" />
                </x-menu>

                <x-menu title="{{ Str::upper('Ventes') }}" url="/vendre">
                    <x-iicon src="/assets/icons/ventes.png" alt="ventes" />
                </x-menu>

                <x-menu title="{{ Str::upper('Retour') }}" url="/retour">
                    {{-- <i class="bi bi-arrow-clockwise"></i> --}}
                    <img src="/assets/images/svg/undo-2.svg" alt="Undo icon">&nbsp;
                </x-menu>
            @endif
        </ul>
    </div>
</div>
