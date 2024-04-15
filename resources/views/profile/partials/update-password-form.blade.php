<section>
    <header>
        <h3 class="text-lg font-medium text-gray-900 mb-0">
            Nouveaux mot de passe
        </h3>

        <p class="mt-0 text-sm text-gray-600">
            Proteger votre compte avec un mot de passe sure .
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="mb-3">
            <label for="update_password_current_password" class="form-label">Ancien mot de passe</label>
            <input autofocus id="update_password_current_password" name="current_password" type="password"
                class="form-control" autocomplete="current-password" />
            @error('current_password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="update_password_password" class="form-label">Nouveaux mot de passe</label>
            <input id="update_password_password" name="password" type="password" class="form-control"
                autocomplete="new-password" />
            @error('password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="update_password_password_confirmation" class="form-label">Confirmation mot de passe</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="form-control" autocomplete="new-password" />
            @error('password_confirmation')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex align-items-center gap-4">
            <button type="submit" class="btn btn-primary w-100">Enregistrer</button>
            @if (session('status') === 'password-updated')
                <p class="text-sm text-gray-600">
                    Mot de passe modifier avec success
                </p>
            @endif
        </div>
    </form>
</section>
