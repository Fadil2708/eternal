@extends('layouts.public')

@section('title', 'Tentang Kami')

@section('content')
<div class="public-page">
    <div class="page-header-center">
        <h1 class="page-title-lg">Tentang Kami</h1>
        <p class="welcome-section-sub">Sistem Informasi Pengelolaan Magang & PKL Telkom Sukabumi</p>
    </div>

    <div class="panel" style="padding:32px">
        <div class="vac-section">
            <h3>Latar Belakang</h3>
            <p class="vac-text">
                Sistem Informasi Pengelolaan Magang & PKL Telkom Sukabumi adalah platform digital yang dikembangkan
                oleh Tim IT Telkom Sukabumi untuk memudahkan proses pendaftaran, monitoring, dan evaluasi program
                magang dan Praktik Kerja Lapangan (PKL) di lingkungan Telkom Sukabumi.
            </p>
        </div>

        <div class="vac-section">
            <h3>Tujuan</h3>
            <p class="vac-text">Platform ini bertujuan untuk:</p>
            <ul style="list-style:disc;padding-left:20px;font-size:13px;color:#52504B;line-height:1.7">
                <li>Mempermudah pendaftaran magang secara digital</li>
                <li>Memantau status lamaran secara real-time</li>
                <li>Mencatat logbook kegiatan harian</li>
                <li>Memudahkan evaluasi oleh pembimbing</li>
                <li>Menerbitkan sertifikat digital dengan QR code terverifikasi</li>
            </ul>
        </div>

        <div class="vac-section">
            <h3>Kontak</h3>

            <div class="contact-map">
                <iframe
                    src="https://www.openstreetmap.org/export/embed.html?bbox=106.9152%2C-6.9257%2C106.9353%2C-6.9157&layer=mapnik&marker=-6.9206966%2C106.9252477"
                    title="Peta Telkom Witel Sukabumi"
                    loading="lazy"
                    allowfullscreen></iframe>
            </div>

            <div class="contact-grid">
                <div class="contact-card">
                    <div class="contact-icon"><i class="ti ti-map-pin"></i></div>
                    <div>
                        <strong class="contact-title">Alamat</strong>
                        <p class="contact-text">
                            Jl. Masjid No. 17, Gunung Parang, Kec. Cikole,<br>
                            Kota Sukabumi, Jawa Barat 43113
                        </p>
                        <a class="contact-action" href="https://maps.app.goo.gl/FQyBPdFQeCeWGrug6" target="_blank" rel="noopener">
                            Buka di Google Maps <i class="ti ti-arrow-up-right"></i>
                        </a>
                    </div>
                </div>

                <div class="contact-card">
                    <div class="contact-icon"><i class="ti ti-mail"></i></div>
                    <div>
                        <strong class="contact-title">Email</strong>
                        <p class="contact-text">magang@telkomsukabumi.co.id</p>
                        <a class="contact-action" href="mailto:magang@telkomsukabumi.co.id">
                            Kirim Email <i class="ti ti-arrow-up-right"></i>
                        </a>
                    </div>
                </div>

                <div class="contact-card">
                    <div class="contact-icon"><i class="ti ti-brand-whatsapp"></i></div>
                    <div>
                        <strong class="contact-title">WhatsApp</strong>
                        <p class="contact-text">+62 858-8168-3025</p>
                        <a class="contact-action" href="https://wa.me/6285881683025?text=Halo%20Telkom%20Sukabumi%2C%20saya%20ingin%20bertanya%20tentang%20program%20magang." target="_blank" rel="noopener">
                            Chat WhatsApp <i class="ti ti-arrow-up-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div style="text-align:center;margin-top:24px">
            <a href="{{ url('/') }}" class="btn-primary"><i class="ti ti-arrow-left"></i> Kembali ke Beranda</a>
        </div>
    </div>
</div>
@endsection
