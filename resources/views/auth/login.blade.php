<x-invite>
    <form action="{{ route('login') }}" method="post" class="card smooth-shadow-lg p-6">
        @csrf

        <div class="content d-flex align-items-center justify-content-center">
            {{-- <img width="100" src="/logo_ben.jpg" class="img-fluid rounded-top" alt="" /> --}}

            <h2>BEN SERVICES</h2>
            {{-- <h2>BEN SERVICES</h2> --}}
        </div>

        @if ($errors->any())
            <div class="alert alert-danger text-center">
                <p>Nom d'utilisateur ou mot de passe incorrect</p>
            </div>
        @endif

        <div class="text-center mb-5 text-primary fw-bold">
            <div class="divider-text mt-1">Veuillez renseigner vos informations de connexion !</div>
        </div>

        <div class="mb-3">
            <label for="u_username" class="form-label">Nom d'utilisateur</label>
            <input type="text" class="form-control @error('u_username') is-invalid @enderror" name="u_username"
                id="u_username" placeholder="Ben" value="{{ old('u_username') }}" required />
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Mot de passe"
                value="{{ old('password') }}" required />
        </div>


        <button type="submit" class="btn btn-primary">
            Se connecter
        </button>

    </form>
</x-invite>
