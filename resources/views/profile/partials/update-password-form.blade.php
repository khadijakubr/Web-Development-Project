<form method="post" action="{{ route('password.update') }}">
    @csrf
    @method('put')

    <div class="mb-3">
        <label for="update_password_current_password" class="form-label">{{ __('Current Password') }}</label>
        <input id="update_password_current_password" name="current_password" type="password" class="form-control @error('updatePassword.current_password') is-invalid @enderror" autocomplete="current-password" />
        @error('updatePassword.current_password')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="update_password_password" class="form-label">{{ __('New Password') }}</label>
        <input id="update_password_password" name="password" type="password" class="form-control @error('updatePassword.password') is-invalid @enderror" autocomplete="new-password" />
        @error('updatePassword.password')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="update_password_password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
        <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control @error('updatePassword.password_confirmation') is-invalid @enderror" autocomplete="new-password" />
        @error('updatePassword.password_confirmation')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex align-items-center gap-3 pt-3 border-top">
        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

        @if (session('status') === 'password-updated')
            <span class="text-muted small">{{ __('Saved.') }}</span>
        @endif
    </div>
</form>
