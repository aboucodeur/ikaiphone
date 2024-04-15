<!-- Sidebar -->
<div class="navbar-vertical navbar nav-dashboard bg-gray-500 ">
    <div class="h-100" data-simplebar>
        <a href="{{ route('home') }}" class="d-flex justify-content-center">
            <img width="90" src="/logo_ben.jpg" class="img-fluid rounded-top" alt="" />
        </a>

        <!-- Navbar nav -->
        <ul class="navbar-nav gap-0 md-0 flex-column text-right" id="sideNavbar">
            {{-- <x-menutitle title="STOCKS" /> --}}

            @if (Auth::user()->u_type === 'admin')
                <x-menu title="{{ Str::upper('Tableaux') }}" url="/">
                    <i class="bi bi-speedometer"></i>&nbsp;
                </x-menu>

                <x-menu title="{{ Str::upper('Modeles') }}" url="/modele">
                    <i class="bi bi-list-ul"></i>&nbsp;
                </x-menu>

                <x-menu title="{{ Str::upper('Iphones') }}" url="/iphone">
                    <i class="bi bi-apple"></i>&nbsp;
                </x-menu>

                <x-menutitle title="{{ Str::upper('ENTREES') }}" />

                <x-menu title="{{ Str::upper('Fournisseur') }}" url="/fournisseur">
                    <i class="bi bi-truck"></i>&nbsp;
                </x-menu>

                <x-menu title="{{ Str::upper('Str')::upper('(Arrivages) Achats') }}" url="/achat">
                    <i class="bi bi-cart2"></i>&nbsp;
                </x-menu>

                <x-menutitle title="{{ Str::upper('Autres') }}" />

                <x-menu title="{{ Str::upper('Utilisateurs') }}" url="/user">
                    <i class="bi bi-people"></i> &nbsp;
                </x-menu>
            @endif

            @if (Auth::user()->u_type === 'user' || Auth::user()->u_type === 'admin')
                <x-menutitle title="{{ Str::upper('SORTIES') }}" />

                <x-menu title="{{ Str::upper('Clients') }}" url="/client">
                    <i class="bi bi-person-lines-fill"></i>&nbsp;
                </x-menu>

                <x-menu title="{{ Str::upper('Ventes') }}" url="/vendre">
                    <i class="bi bi-basket-fill"></i>&nbsp;
                </x-menu>

                <x-menu title="{{ Str::upper('Retour') }}" url="/retour">
                    <i class="bi bi-arrow-down-left-circle-fill"></i>&nbsp;
                </x-menu>
            @endif
        </ul>
    </div>
</div>
