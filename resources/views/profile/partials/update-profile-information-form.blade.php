<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}">
    @csrf
    @method('patch')

    <div class="mb-3">
        <label for="name" class="form-label">{{ __('Name') }}</label>
        <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
        @error('name')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

<div class="mb-3">
        <label for="email" class="form-label">{{ __('Email') }}</label>
        <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required autocomplete="username" />
        @error('email')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="mt-3">
                <p class="text-muted small mb-2">
                    {{ __('Your email address is unverified.') }}
                </p>
                <button type="submit" form="send-verification" class="btn btn-link btn-sm p-0">
                    {{ __('Click here to re-send the verification email.') }}
                </button>

                @if (session('status') === 'verification-link-sent')
                    <div class="alert alert-success alert-sm mt-2 mb-0">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </div>
                    @endif
                </div>
            @endif
        </div>

    <div class="mb-3">
        <label for="phone" class="form-label">{{ __('Phone Number') }}</label>
        <small class="text-muted">{{ __('Optional') }}</small>
        <input id="phone" name="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}" autocomplete="tel" placeholder="+62..." />
        @error('phone')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="address" class="form-label">{{ __('Address') }}</label>
        <small class="text-muted">{{ __('Optional') }}</small>
        <textarea id="address" name="address" class="form-control @error('address') is-invalid @enderror" rows="3" autocomplete="street-address" placeholder="Enter your address">{{ old('address', $user->address) }}</textarea>
        @error('address')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex align-items-center gap-3 pt-3 border-top">
        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

        @if (session('status') === 'profile-updated')
            <span class="text-muted small">{{ __('Saved.') }}</span>
        @endif
    </div>
</form>
