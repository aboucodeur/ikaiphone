<x-invite>
    <form action="{{ route('register') }}" method="post" class="card smooth-shadow-lg p-6">
        @csrf

        <div class="content d-flex align-items-center justify-content-center">
            <h2>BEN SERVICES</h2>
            {{-- <h2>SAIWA</h2> --}}
        </div>

        <div class="text-center mb-5 text-primary fw-bold">
            <div class="divider-text">Veuillez renseigner vos informations de connexion !</div>
        </div>

        <div class="mb-3">
            <label for="u_username" class="form-label">Nom d'utilisateur</label>
            <input type="text" class="form-control" name="u_username" id="u_username" placeholder="Aboubacar"
                value="{{ old('u_username') }}" required />
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="u_prenom" class="form-label">Prenom</label>
                    <input autofocus type="text" class="form-control" name="u_prenom" id="u_prenom"
                        placeholder="Prenom ici" value="{{ old('u_prenom') }}" required />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="u_nom" class="form-label">Nom</label>
                    <input type="text" class="form-control" name="u_nom" id="u_nom" placeholder="Nom ici"
                        value="{{ old('u_nom') }}" required />
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="" class="form-label">Type d'utilisateur</label>
            <select class="form-select form-select-lg" name="u_type" required>
                <option selected>Selectionnez le type de l'utilisateur</option>
                <option selected value="user">Utilisateur simple (vendeur)</option>
                <option value="admin">Administrateur</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="" class="form-label">Email </label>
            <input type="email" class="form-control" name="email" placeholder="abc@mail.com"
                value="{{ old('email') }}" required />
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder=""
                        value="{{ old('password') }}" required />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmation mot de passe</label>
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation"
                        placeholder="" value="{{ old('password_confirmation') }}" required />
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">
            Creer le compte
        </button>

    </form>
</x-invite>
