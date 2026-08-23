<section>
    <div class="acp-card-head">
        <div class="acp-card-icon"><i class="ti ti-trash"></i></div>
        <div>
            <h3 class="acp-card-title">Hapus Akun</h3>
            <p class="acp-card-sub">
                Setelah akun dihapus, semua data akan terhapus permanen. Unduh data yang ingin Anda simpan sebelum melanjutkan.
            </p>
        </div>
    </div>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="acp-danger-btn"
    ><i class="ti ti-trash"></i> {{ __('Delete Account') }}</button>

    <x-modal name="confirm-user-deletion" title="Konfirmasi Hapus Akun" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}">
            @csrf
            @method('delete')

            <h3 class="acp-modal-title">{{ __('Are you sure you want to delete your account?') }}</h3>

            <p class="acp-modal-text">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="acp-field">
                <label for="password" class="acp-label">{{ __('Password') }}</label>
                <input id="password" name="password" type="password" class="acp-input" placeholder="{{ __('Password') }}">
                @error('password', 'userDeletion') <div class="acp-error">{{ $message }}</div> @enderror
            </div>

            <div class="acp-modal-footer"
                  x-data="{ loading: false }"
                  @submit="loading = true">
                <button type="button" x-on:click="$dispatch('close')" class="acp-btn-cancel">Batal</button>
                <button type="submit"
                        class="acp-danger-btn"
                        x-bind:disabled="loading">
                    <i x-show="!loading" class="ti ti-trash"></i>
                    <i x-show="loading" class="ti ti-loader acp-spin"></i>
                    <span x-show="!loading">Hapus Akun</span>
                    <span x-show="loading">Memproses...</span>
                </button>
            </div>
        </form>
    </x-modal>
</section>