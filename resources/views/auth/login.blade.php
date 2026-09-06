<x-guest-layout>
    @section('title', 'Masuk')

    <div class="auth-form-header text-center">
        <div class="icon-circle-brand-lg">
            <i class="ti ti-login"></i>
        </div>
        <h2 class="auth-title">Selamat Datang Kembali</h2>
        <p class="auth-desc">Masuk untuk mengakses dashboard Anda</p>
    </div>

    <x-auth-session-status :status="session('status')" />

    <form method="POST" action="{{ route('login',[], false) }}" x-data="{ showPassword: false, loading: false }" @submit="loading = true">
        @csrf

        <div class="field">
            <label for="email">Email</label>
            <div class="input-wrap">
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="nama@email.com" class="input">
                <i class="ti ti-mail input-icon"></i>
            </div>
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div class="field field-group">
            <div class="label-row">
                <label for="password">Password</label>
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">Lupa password?</a>
                @endif
            </div>
            <div class="input-wrap">
                <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan password" class="input"
                       x-bind:type="showPassword ? 'text' : 'password'">
                <i class="ti ti-lock input-icon"></i>
                <button type="button" @click="showPassword = !showPassword" class="password-toggle">
                    <i x-show="!showPassword" x-cloak class="ti ti-eye"></i>
                    <i x-show="showPassword" x-cloak class="ti ti-eye-off"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <label class="checkbox-wrap">
            <input id="remember_me" type="checkbox" name="remember">
            <span>Ingat saya di perangkat ini</span>
        </label>

        <button type="submit"
                class="btn-primary btn-full mt-20"
                x-bind:disabled="loading"
                x-bind:class="loading ? 'btn-loading' : ''">
            <i x-show="!loading" class="ti ti-login-2"></i>
            <i x-show="loading" class="ti ti-loader spin"></i>
            <span x-show="!loading">Masuk</span>
            <span x-show="loading">Memproses...</span>
        </button>

        <p class="auth-footer">
            Belum punya akun?
            <a href="{{ route('register') }}" class="link-brand">Daftar akun baru</a>
        </p>
    </form>
</x-guest-layout>
