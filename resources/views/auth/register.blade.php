<x-guest-layout>
    @section('title', 'Daftar')

    @php
        $validRoles = ['intern', 'supervisor'];
        $activeRole = in_array(request()->query('role', 'intern'), $validRoles)
            ? request()->query('role', 'intern')
            : 'intern';
        $code = old('code', request()->query('code', ''));
    @endphp

    @section('auth-init', $activeRole)

    <div class="auth-tab-group">
        <button @click="role = 'intern'" :class="role === 'intern' ? 'auth-tab active' : 'auth-tab'">
            <i class="ti ti-users"></i> Peserta Magang
        </button>
        <button @click="role = 'supervisor'" :class="role === 'supervisor' ? 'auth-tab active' : 'auth-tab'">
            <i class="ti ti-user-star"></i> Pembimbing
        </button>
    </div>

    {{-- Intern Form --}}
    <div x-show="role === 'intern'">
        <div class="auth-form-header text-center">
            <div class="icon-circle-brand-lg">
                <i class="ti ti-user-plus"></i>
            </div>
            <h2 class="auth-title">Buat Akun Baru</h2>
            <p class="auth-desc">Daftar untuk memulai perjalanan magang Anda</p>
        </div>

        <form method="POST" action="{{ route('register',[], false) }}" x-data="{ showPassword: false, showConfirm: false, loading: false, password: '' }" @submit="loading = true">
            @csrf

            <div class="field">
                <label for="email">Email</label>
                <div class="input-wrap">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="nama@email.com" class="input">
                    <i class="ti ti-mail input-icon"></i>
                </div>
                <x-input-error :messages="$errors->get('email')" />
            </div>

            <div class="field field-group">
                <label for="full_name">Nama Lengkap</label>
                <div class="input-wrap">
                    <input id="full_name" type="text" name="full_name" value="{{ old('full_name') }}" required autocomplete="name" placeholder="Masukkan nama lengkap" class="input">
                    <i class="ti ti-user input-icon"></i>
                </div>
                <x-input-error :messages="$errors->get('full_name')" />
            </div>

            <div class="field field-group">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Masukkan password" class="input"
                           x-bind:type="showPassword ? 'text' : 'password'" x-model="password">
                    <i class="ti ti-lock input-icon"></i>
                    <button type="button" @click="showPassword = !showPassword" class="password-toggle">
                        <i x-show="!showPassword" x-cloak class="ti ti-eye"></i>
                        <i x-show="showPassword" x-cloak class="ti ti-eye-off"></i>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" />
                <div class="pw-requirements">
                    <div class="pw-req" :style="password.length >= 8 ? 'color:#16A34A' : ''">
                        <i :class="password.length >= 8 ? 'ti ti-check' : 'ti ti-circle'"></i>
                        Minimal 8 karakter
                    </div>
                    <div class="pw-req" :style="/[A-Z]/.test(password) ? 'color:#16A34A' : ''">
                        <i :class="/[A-Z]/.test(password) ? 'ti ti-check' : 'ti ti-circle'"></i>
                        Huruf besar (A-Z)
                    </div>
                    <div class="pw-req" :style="/[a-z]/.test(password) ? 'color:#16A34A' : ''">
                        <i :class="/[a-z]/.test(password) ? 'ti ti-check' : 'ti ti-circle'"></i>
                        Huruf kecil (a-z)
                    </div>
                    <div class="pw-req" :style="/[0-9]/.test(password) ? 'color:#16A34A' : ''">
                        <i :class="/[0-9]/.test(password) ? 'ti ti-check' : 'ti ti-circle'"></i>
                        Angka (0-9)
                    </div>
                    <div class="pw-req" :style="/[^A-Za-z0-9]/.test(password) ? 'color:#16A34A' : ''">
                        <i :class="/[^A-Za-z0-9]/.test(password) ? 'ti ti-check' : 'ti ti-circle'"></i>
                        Simbol (!@#$...)
                    </div>
                </div>
            </div>

            <div class="field field-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <div class="input-wrap">
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password" class="input"
                           x-bind:type="showConfirm ? 'text' : 'password'">
                    <i class="ti ti-lock-check input-icon"></i>
                    <button type="button" @click="showConfirm = !showConfirm" class="password-toggle">
                        <i x-show="!showConfirm" x-cloak class="ti ti-eye"></i>
                        <i x-show="showConfirm" x-cloak class="ti ti-eye-off"></i>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" />
            </div>

            <button type="submit"
                    class="btn-primary btn-full mt-20"
                    x-bind:disabled="loading"
                    x-bind:class="loading ? 'btn-loading' : ''">
                <i x-show="!loading" class="ti ti-user-check"></i>
                <i x-cloak x-show="loading" class="ti ti-loader spin"></i>
                <span x-show="!loading">Daftar</span>
                <span x-cloak x-show="loading">Memproses...</span>
            </button>

            <p class="auth-footer">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="link-brand">Masuk di sini</a>
            </p>
        </form>
    </div>

    {{-- Supervisor Form --}}
    <div x-show="role === 'supervisor'" x-cloak>
        <div class="auth-form-header text-center">
            <div class="icon-circle-brand-lg">
                <i class="ti ti-user-star"></i>
            </div>
            <h2 class="auth-title">Daftar sebagai Pembimbing</h2>
            <p class="auth-desc">Gunakan kode undangan dari admin untuk mendaftar</p>
        </div>

        <form method="POST" action="{{ route('register.supervisor',[], false) }}" x-data="{ showPassword: false, showConfirm: false, loading: false, password: '' }" @submit="loading = true">
            @csrf

            <div class="field">
                <label for="code">Kode Undangan</label>
                <div class="input-wrap">
                    <input id="code" type="text" name="code" value="{{ $code }}" required class="input input-code" placeholder="Contoh: A1B2C3D4">
                    <i class="ti ti-ticket input-icon"></i>
                </div>
                <x-input-error :messages="$errors->get('code')" />
            </div>

            <div class="field field-group">
                <label for="supervisor_email">Email</label>
                <div class="input-wrap">
                    <input id="supervisor_email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="pembimbing@eternalinternship.id" class="input">
                    <i class="ti ti-mail input-icon"></i>
                </div>
                <x-input-error :messages="$errors->get('email')" />
            </div>

            <div class="field field-group">
                <label for="supervisor_password">Password</label>
                <div class="input-wrap">
                    <input id="supervisor_password" type="password" name="password" required autocomplete="new-password" placeholder="Masukkan password" class="input"
                           x-bind:type="showPassword ? 'text' : 'password'" x-model="password">
                    <i class="ti ti-lock input-icon"></i>
                    <button type="button" @click="showPassword = !showPassword" class="password-toggle">
                        <i x-show="!showPassword" x-cloak class="ti ti-eye"></i>
                        <i x-show="showPassword" x-cloak class="ti ti-eye-off"></i>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" />
                <div class="pw-requirements">
                    <div class="pw-req" :style="password.length >= 8 ? 'color:#16A34A' : ''">
                        <i :class="password.length >= 8 ? 'ti ti-check' : 'ti ti-circle'"></i>
                        Minimal 8 karakter
                    </div>
                    <div class="pw-req" :style="/[A-Z]/.test(password) ? 'color:#16A34A' : ''">
                        <i :class="/[A-Z]/.test(password) ? 'ti ti-check' : 'ti ti-circle'"></i>
                        Huruf besar (A-Z)
                    </div>
                    <div class="pw-req" :style="/[a-z]/.test(password) ? 'color:#16A34A' : ''">
                        <i :class="/[a-z]/.test(password) ? 'ti ti-check' : 'ti ti-circle'"></i>
                        Huruf kecil (a-z)
                    </div>
                    <div class="pw-req" :style="/[0-9]/.test(password) ? 'color:#16A34A' : ''">
                        <i :class="/[0-9]/.test(password) ? 'ti ti-check' : 'ti ti-circle'"></i>
                        Angka (0-9)
                    </div>
                    <div class="pw-req" :style="/[^A-Za-z0-9]/.test(password) ? 'color:#16A34A' : ''">
                        <i :class="/[^A-Za-z0-9]/.test(password) ? 'ti ti-check' : 'ti ti-circle'"></i>
                        Simbol (!@#$...)
                        Simbol (!@#$...)
                    </div>
                </div>
            </div>

            <div class="field field-group">
                <label for="supervisor_password_confirmation">Konfirmasi Password</label>
                <div class="input-wrap">
                    <input id="supervisor_password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password" class="input"
                           x-bind:type="showConfirm ? 'text' : 'password'">
                    <i class="ti ti-lock-check input-icon"></i>
                    <button type="button" @click="showConfirm = !showConfirm" class="password-toggle">
                        <i x-show="!showConfirm" x-cloak class="ti ti-eye"></i>
                        <i x-show="showConfirm" x-cloak class="ti ti-eye-off"></i>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" />
            </div>

            <button type="submit"
                    class="btn-primary btn-full mt-20"
                    x-bind:disabled="loading"
                    x-bind:class="loading ? 'btn-loading' : ''">
                <i x-show="!loading" class="ti ti-user-check"></i>
                <i x-cloak x-show="loading" class="ti ti-loader spin"></i>
                <span x-show="!loading">Daftar</span>
                <span x-cloak x-show="loading">Memproses...</span>
            </button>

            <p class="auth-footer">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="link-brand">Masuk di sini</a>
            </p>
        </form>
    </div>
</x-guest-layout>