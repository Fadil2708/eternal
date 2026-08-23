<section class="section" id="faq" data-reveal>
    <div class="container">

        <div class="section-heading">
            <span class="section-label">FAQ</span>
            <h2 class="section-title">Pertanyaan yang Sering Diajukan</h2>
        </div>

        <div class="faq-list">
            @forelse($faqs as $faq)
            <details class="faq-item">
                <summary>{{ $faq->question }}</summary>
                <p>{{ $faq->answer }}</p>
            </details>
            @empty
            <div class="vacancy-empty">
                <i class="ti ti-message-off"></i>
                <p>Belum ada pertanyaan umum.</p>
            </div>
            @endforelse
        </div>

    </div>
</section>