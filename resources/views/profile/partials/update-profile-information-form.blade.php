<section>
    <div class="acp-card-head">
        <div class="acp-card-icon"><i class="ti ti-user"></i></div>
        <div>
            <h3 class="acp-card-title">Informasi Profil</h3>
            <p class="acp-card-sub">Perbarui informasi akun dan email Anda.</p>
        </div>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="acp-field">
            <label for="email" class="acp-label">Email</label>
            <input id="email" name="email" type="email" class="acp-input" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email') <div class="acp-error">{{ $message }}</div> @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="acp-info">
                    <i class="ti ti-mail-exclamation"></i>
                    <div>
                        <p>
                            {{ __('Your email address is unverified.') }}
                            <button form="send-verification">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>
                        @if (session('status') === 'verification-link-sent')
                            <p class="acp-info-success">
                                <i class="ti ti-circle-check"></i>
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <div class="acp-footer">
            <button type="submit"
                    class="acp-submit"
                    x-cloak
                    x-data="{ loading: false }"
                    x-on:click="loading = true"
                    x-bind:disabled="loading">
                <i x-show="!loading" class="ti ti-device-floppy"></i>
                <i x-show="loading" class="ti ti-loader acp-spin"></i>
                <span x-show="!loading">Simpan</span>
                <span x-show="loading">Menyimpan...</span>
            </button>
            @if (session('status') === 'profile-updated')
                <p x-data="timedHide" x-show="show" x-transition class="acp-saved">
                    <i class="ti ti-circle-check"></i> {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>