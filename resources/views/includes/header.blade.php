<!-- navbar -->
<div class="navbar-custom navbar navbar-expand-lg w-100">
    <div class="container-fluid px-0">
        <a class="navbar-brand d-block d-md-none" href="index.html">
            <img src="assets/images/brand/logo/logo-2.svg" alt="Image">
        </a>

        <!-- Hamburger menu -->
        <a id="nav-toggle" href="#!" class="ms-auto ms-md-0 me-0 me-lg-3 ">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor"
                class="bi bi-text-indent-left text-muted" viewBox="0 0 16 16">
                <path
                    d="M2 3.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm.646 2.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1 0 .708l-2 2a.5.5 0 0 1-.708-.708L4.293 8 2.646 6.354a.5.5 0 0 1 0-.708zM7 6.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm-5 3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z" />
            </svg>
        </a>

        <!--Navigation -->
        <ul class="navbar-nav navbar-right-wrap ms-lg-auto d-flex nav-top-wrap align-items-center ms-4 ms-lg-0">
            <!-- Light Mode / Dark Mode -->
            <li>
                <a href="#"
                    class="form-check form-switch theme-switch btn btn-ghost btn-icon rounded-circle mb-0 ">
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                    <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                </a>
            </li>

            <!-- Profile dropdown -->
            <li class="dropdown ms-2">
                <a class="rounded-circle" href="" role="button" id="dropdownUser" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <div
                        class="d-flex align-items-center justify-content-center text-center avatar-md bg-primary rounded-lg">
                        {{-- <img alt="avatar" src="" class="rounded-circle"> --}}
                        <h4 class="text-white mt-1">{{ Auth::user()->u_prenom[0] }}</h4>
                        <h4 class="text-white mt-1">{{ Auth::user()->u_nom[0] }}</h4>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                    <div class="px-4 pb-0 pt-2">
                        <div class="lh-1 ">
                            <h5 class="mb-1">{{ Auth::user()->u_prenom }} {{ Auth::user()->u_nom }}</h5>
                            <span>Type : {{ Auth::user()->u_type }}</span>
                        </div>
                        <div class=" dropdown-divider mt-3 mb-2"></div>
                    </div>
                    <ul class="list-unstyled">
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.edit') }}">
                                <i class="me-2 icon-xxs dropdown-item-icon" data-feather="user"></i>
                                Mot de passe
                            </a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="me-2 icon-xxs dropdown-item-icon" data-feather="power"></i>
                                    Deconnexion
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>

    </div>
</div>
