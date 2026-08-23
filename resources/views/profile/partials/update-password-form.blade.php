<section>
    <div class="acp-card-head">
        <div class="acp-card-icon"><i class="ti ti-key"></i></div>
        <div>
            <h3 class="acp-card-title">Ubah Password</h3>
            <p class="acp-card-sub">Pastikan akun Anda menggunakan password yang kuat dan acak.</p>
        </div>
    </div>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="acp-field">
            <label for="update_password_current_password" class="acp-label">Password Saat Ini</label>
            <input id="update_password_current_password" name="current_password" type="password" class="acp-input" autocomplete="current-password">
            @error('current_password', 'updatePassword') <div class="acp-error">{{ $message }}</div> @enderror
        </div>

        <div class="acp-field">
            <label for="update_password_password" class="acp-label">Password Baru</label>
            <input id="update_password_password" name="password" type="password" class="acp-input" autocomplete="new-password">
            @error('password', 'updatePassword') <div class="acp-error">{{ $message }}</div> @enderror
        </div>

        <div class="acp-field">
            <label for="update_password_password_confirmation" class="acp-label">Konfirmasi Password</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="acp-input" autocomplete="new-password">
            @error('password_confirmation', 'updatePassword') <div class="acp-error">{{ $message }}</div> @enderror
        </div>

        <div class="acp-footer">
            <button type="submit"
                    class="acp-submit"
                    x-data="{ loading: false }"
                    x-on:click="loading = true"
                    x-bind:disabled="loading">
                <i x-show="!loading" class="ti ti-device-floppy"></i>
                <i x-show="loading" class="ti ti-loader acp-spin"></i>
                <span x-show="!loading">Simpan</span>
                <span x-show="loading">Menyimpan...</span>
            </button>
            @if (session('status') === 'password-updated')
                <p x-data="timedHide" x-show="show" x-transition class="acp-saved">
                    <i class="ti ti-circle-check"></i> {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>