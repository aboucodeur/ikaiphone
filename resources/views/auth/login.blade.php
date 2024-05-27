<x-invite>
    <form action="{{ route('login') }}" method="post" class="card shadow-lg p-6">
        @csrf

        <div class="content d-row text-center align-items-center justify-content-center gap-5 mb-5">
            {{-- <img width="100" src="/assets/images/ben_services_logo.png" class="img-fluid rounded-top" alt="" /> --}}
            <h2>IKA IPHONE</h2>
            <small
                title="Nous savons que la vente d'iphone n'est pas facile. C'est pour cela avec IKA IPHONE vous allez faire le compte facilement,rapidement et sans mettre votre vie en danger oui"
                class="text-muted fs-3">Allez a la maison
                sans probleme !</small>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger text-center">
                <p>Nom d'utilisateur ou mot de passe incorrect</p>
            </div>
        @endif

        <div>
            <label for="u_username" class="form-label">Utilisateur (*)</label>
            <div class="input-group mb-3">
                <input autofocus type="text" class="form-control @error('u_username') is-invalid @enderror"
                    name="u_username" id="u_username" placeholder="aboubacar" value="{{ old('u_username') }}"
                    required />
                <span class="input-group-text w-10">
                    <img src="/assets/images/svg/user.svg" alt="User icon">
                </span>
            </div>
        </div>



        <div>
            <label for="password" class="form-label">Mot de passe (*)</label>
            <div class="input-group mb-3">
                <input type="password" class="form-control" name="password" id="password" placeholder="Mot de passe"
                    value="{{ old('password') }}" required />
                <span class="input-group-text w-10" id="passIcon">
                    <img src="/assets/images/svg/eye-password-show.svg" alt="Eye icon">
                </span>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">
            Se connecter
        </button>
    </form>
</x-invite>

<script>
    $(function() {
        // plus performant encore avec moins de ligne
        $("#passIcon").click(function() {
            let type = $("#password").attr("type") === "password" ? "text" : "password";
            $("#password").attr("type", type);
            $(this).find('img').attr("src", type === "text" ?
                "/assets/images/svg/eye-password-hide.svg" :
                "/assets/images/svg/eye-password-show.svg");
        });
    })
</script>
