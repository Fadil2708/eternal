<section class="cta" data-reveal>
    <div class="container">
        <div class="cta-box">
            <div class="cta-content">
                <h2>Siap Mengelola Program Magang Perusahaan dengan Lebih Baik?</h2>
                <p>Gunakan Eternal untuk mengelola seluruh proses magang dengan lebih terstruktur, terintegrasi, dan mudah.</p>
            </div>

            <div style="display:flex;gap:10px;flex-wrap:wrap;">
                @auth
                    <a href="{{ route('public.vacancies') }}" class="cta-button">
                        <i class="ti ti-briefcase"></i> Lihat Lowongan
                    </a>
                @else
                    <a href="{{ route('register') }}" class="cta-button">
                        <i class="ti ti-user-plus"></i> Daftar Sekarang
                    </a>
                    <a href="{{ route('login') }}" class="cta-button cta-button-ghost">
                        <i class="ti ti-login"></i> Masuk
                    </a>
                @endauth
            </div>
        </div>
    </div>
</section>