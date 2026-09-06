@php
    $user = auth()->user();
    $role = $user->role ?? 'intern';
    $currentRoute = request()->route()?->getName() ?? '';
    $itemIndex = 0;
@endphp

<aside class="sidebar" :class="sidebarOpen ? 'open' : ''"
       x-transition:enter="transition-all duration-300 ease-out"
       x-transition:enter-start="-translate-x-full opacity-0"
       x-transition:enter-end="translate-x-0 opacity-100"
       x-transition:leave="transition-all duration-200 ease-in"
       x-transition:leave-start="translate-x-0 opacity-100"
       x-transition:leave-end="-translate-x-full opacity-0">
    <div class="sidebar-header">
        <a href="{{ route('dashboard') }}" class="sidebar-logo" x-data="{ loaded: false }" x-init="$nextTick(() => loaded = true)">
            <picture><source srcset="{{ asset('images/LogoEternalUtama.webp') }}" type="image/webp"><img src="{{ asset('images/LogoEternalUtama.webp') }}" alt="Eternal Internship" class="sidebar-logo-img" :class="loaded ? 'scale-100 opacity-100' : 'scale-75 opacity-0'" style="transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275)"></picture>
        </a>
    </div>

    <nav class="sidebar-nav" x-data="{ hoveredItem: null }">
        @if($role === 'admin')
            <div class="sb-nav-section" style="animation: sidebarFadeSlideIn 0.3s ease-out {{ 0 * 50 }}ms backwards">Manajemen</div>
            <x-sidebar-item :route="'admin.dashboard'" :icon="'ti-dashboard'" :label="'Dashboard'" :animation-delay="1" />

            <div class="sb-nav-section" style="animation: sidebarFadeSlideIn 0.3s ease-out {{ 2 * 50 }}ms backwards">Data Master</div>
            <x-sidebar-item :route="'admin.users*'" :icon="'ti-users'" :label="'Pengguna'" :animation-delay="3" />
            <x-sidebar-item :route="'admin.vacancies.*'" :icon="'ti-briefcase'" :label="'Lowongan'" :animation-delay="4" />

            <div class="sb-nav-section" style="animation: sidebarFadeSlideIn 0.3s ease-out {{ 5 * 50 }}ms backwards">Proses</div>
            <x-sidebar-item :route="'admin.applications.*'" :icon="'ti-file-description'" :label="'Lamaran'" :animation-delay="6" />
            <x-sidebar-item :route="'admin.internships*'" :icon="'ti-users'" :label="'Peserta Magang'" :animation-delay="7" />
            <x-sidebar-item :route="'admin.supervisors.*'" :icon="'ti-user-check'" :label="'Pembimbing'" :animation-delay="8" />

            <div class="sb-nav-section" style="animation: sidebarFadeSlideIn 0.3s ease-out {{ 9 * 50 }}ms backwards">Monitoring</div>
            <x-sidebar-item :route="'admin.logbooks'" :icon="'ti-notebook'" :label="'Logbook'" :animation-delay="10" />
            <x-sidebar-item :route="'admin.reports'" :icon="'ti-file-report'" :label="'Laporan'" :animation-delay="11" />

            <div class="sb-nav-section" style="animation: sidebarFadeSlideIn 0.3s ease-out {{ 12 * 50 }}ms backwards">Penilaian &amp; Sertifikat</div>
            <x-sidebar-item :route="'admin.evaluations'" :icon="'ti-star'" :label="'Penilaian'" :animation-delay="13" />
            <x-sidebar-item :route="'admin.certificates*'" :icon="'ti-certificate'" :label="'Sertifikat'" :animation-delay="14" />

            <div class="sb-nav-section" style="animation: sidebarFadeSlideIn 0.3s ease-out {{ 15 * 50 }}ms backwards">Lainnya</div>
            <x-sidebar-item :route="'admin.invites*'" :icon="'ti-link'" :label="'Undangan'" :animation-delay="16" />
            <x-sidebar-item :route="'admin.faq*'" :icon="'ti-question-mark'" :label="'FAQ'" :animation-delay="17" />
            <x-sidebar-item :route="'admin.skills*'" :icon="'ti-tool'" :label="'Keahlian'" :animation-delay="18" />
            <x-sidebar-item :route="'admin.testimonials*'" :icon="'ti-message-star'" :label="'Testimoni'" :animation-delay="19" />

        @elseif($role === 'supervisor')
            <x-sidebar-item :route="'supervisor.dashboard'" :icon="'ti-dashboard'" :label="'Dashboard'" :animation-delay="0" />
            <x-sidebar-item :route="'supervisor.profile'" :icon="'ti-user'" :label="'Profil'" :animation-delay="1" />
            <x-sidebar-item :route="'supervisor.interns.*'" :icon="'ti-users'" :label="'Peserta'" :animation-delay="2" />
            <x-sidebar-item :route="'supervisor.logbooks'" :icon="'ti-notebook'" :label="'Logbook'" :animation-delay="3" />
            <x-sidebar-item :route="'supervisor.reports'" :icon="'ti-file-report'" :label="'Laporan'" :animation-delay="4" />
            <x-sidebar-item :route="'supervisor.evaluations.*'" :icon="'ti-star'" :label="'Penilaian'" :animation-delay="5" />

        @else
            <x-sidebar-item :route="'intern.dashboard'" :icon="'ti-dashboard'" :label="'Dashboard'" :animation-delay="0" />
            <x-sidebar-item :route="'intern.profile'" :icon="'ti-user'" :label="'Profil'" :animation-delay="1" />

            <div class="sb-nav-section" style="animation: sidebarFadeSlideIn 0.3s ease-out {{ 2 * 50 }}ms backwards">Pendaftaran</div>
            <x-sidebar-item :route="'intern.vacancies'" :icon="'ti-briefcase'" :label="'Lowongan'" :animation-delay="3" />
            <x-sidebar-item :route="'intern.applications'" :icon="'ti-file-description'" :label="'Lamaran'" :animation-delay="4" />

            <div class="sb-nav-section" style="animation: sidebarFadeSlideIn 0.3s ease-out {{ 5 * 50 }}ms backwards">Kegiatan</div>
            <x-sidebar-item :route="'intern.internship'" :icon="'ti-clipboard-list'" :label="'Detail Magang'" :animation-delay="6" />
            <x-sidebar-item :route="'intern.logbooks*'" :icon="'ti-notebook'" :label="'Logbook'" :animation-delay="7" />
            <x-sidebar-item :route="'intern.reports'" :icon="'ti-file-report'" :label="'Laporan Akhir'" :animation-delay="8" />

            <div class="sb-nav-section" style="animation: sidebarFadeSlideIn 0.3s ease-out {{ 9 * 50 }}ms backwards">Penyelesaian</div>
            <x-sidebar-item :route="'intern.evaluation'" :icon="'ti-star'" :label="'Nilai'" :animation-delay="10" />
            <x-sidebar-item :route="'intern.certificate'" :icon="'ti-certificate'" :label="'Sertifikat'" :animation-delay="11" />
            <x-sidebar-item :route="'intern.testimonials.create'" :icon="'ti-message-star'" :label="'Testimoni'" :animation-delay="12" />
        @endif
    </nav>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="{{ route('logout') }}"
               @click.prevent="$el.closest('form').submit()"
               class="sb-nav-item">
                <i class="ti ti-logout"></i>
                <span>Keluar</span>
            </a>
        </form>
    </div>
</aside>
