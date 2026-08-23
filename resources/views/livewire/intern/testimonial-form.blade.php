<div class="tst-root">
    <style>
        .tst-root {
            --tst-primary: #3155e7;
            --tst-primary-dark: #2444c9;
            --tst-primary-light: #eef2ff;
            --tst-text: #111936;
            --tst-muted: #64708a;
            --tst-border: #e5e7eb;
        }

        /* ═══ HEADER ═══ */
        .tst-header { margin-bottom: 22px; }
        .tst-title {
            font-size: 22px;
            font-weight: 800;
            color: var(--tst-text);
            margin: 2px 0 4px;
            line-height: 1.3;
        }
        .tst-sub { font-size: 13px; color: var(--tst-muted); margin: 0; }

        /* ═══ WRAP ═══ */
        .tst-wrap { max-width: 720px; margin: 0 auto; }
        .tst-card {
            background: #fff;
            border: 1px solid var(--tst-border);
            border-radius: 14px;
            padding: 26px;
        }

        /* ═══ EMPTY STATE ═══ */
        .tst-empty {
            text-align: center;
            padding: 48px 24px;
            background: #fff;
            border: 1px solid var(--tst-border);
            border-radius: 14px;
        }
        .tst-empty-icon {
            width: 68px;
            height: 68px;
            margin: 0 auto 16px;
            border-radius: 18px;
            background: var(--tst-primary-light);
            color: var(--tst-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
        }
        .tst-empty-title {
            font-size: 16px;
            font-weight: 800;
            color: var(--tst-text);
            margin: 0 0 6px;
        }
        .tst-empty-sub {
            font-size: 13px;
            color: var(--tst-muted);
            max-width: 400px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* ═══ SUCCESS ═══ */
        .tst-success {
            text-align: center;
            padding: 40px 26px;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 14px;
        }
        .tst-success-icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 14px;
            border-radius: 50%;
            background: #22c55e;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
        }
        .tst-success-title {
            font-size: 18px;
            font-weight: 800;
            color: #14532d;
            margin: 0 0 6px;
        }
        .tst-success-desc {
            font-size: 13px;
            color: #4d7c5f;
            max-width: 400px;
            margin: 0 auto;
            line-height: 1.6;
        }
        .tst-preview {
            max-width: 400px;
            margin: 20px auto 0;
            background: #fff;
            border: 1px solid #bbf7d0;
            border-radius: 12px;
            padding: 16px 18px;
            text-align: left;
        }
        .tst-preview-stars {
            display: flex;
            gap: 3px;
            margin-bottom: 8px;
        }
        .tst-preview-stars i { font-size: 16px; color: #f59e0b; }
        .tst-preview-stars i.off { color: #d1d5db; }
        .tst-preview-text {
            margin: 0;
            font-size: 13px;
            color: var(--tst-text);
            line-height: 1.6;
            font-style: italic;
        }
        .tst-success-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 22px;
            padding: 11px 24px;
            border-radius: 11px;
            background: var(--tst-primary);
            color: #fff;
            font-weight: 700;
            font-size: 13px;
            text-decoration: none;
            transition: background .15s ease;
        }
        .tst-success-back:hover { background: var(--tst-primary-dark); }

        /* ═══ FORM ═══ */
        .tst-card-title {
            font-size: 18px;
            font-weight: 800;
            color: var(--tst-text);
            margin: 0 0 4px;
        }
        .tst-card-sub {
            font-size: 13px;
            color: var(--tst-muted);
            margin: 0 0 24px;
        }
        .tst-field { margin-bottom: 22px; }
        .tst-label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: var(--tst-text);
            margin-bottom: 8px;
        }
        .tst-required { color: #ef4444; }
        .tst-stars {
            display: flex;
            gap: 8px;
        }
        .tst-star {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            font-size: 30px;
            line-height: 1;
            color: #d1d5db;
            transition: transform .12s ease, color .12s ease;
        }
        .tst-star:hover { transform: scale(1.12); }
        .tst-star.on { color: #f59e0b; }
        .tst-star:focus { outline: none; }
        .tst-star-label {
            font-size: 12px;
            color: var(--tst-muted);
            margin: 6px 0 0;
        }
        .tst-input {
            width: 100%;
            padding: 11px 14px;
            border: 1px solid var(--tst-border);
            border-radius: 11px;
            font-size: 14px;
            font-family: inherit;
            color: var(--tst-text);
            background: #fff;
            resize: vertical;
            transition: border-color .15s ease, box-shadow .15s ease;
            line-height: 1.6;
        }
        .tst-input:focus {
            outline: none;
            border-color: var(--tst-primary);
            box-shadow: 0 0 0 3px rgba(49, 85, 231, .14);
        }
        .tst-counter {
            display: flex;
            justify-content: flex-end;
            font-size: 12px;
            color: var(--tst-muted);
            margin-top: 5px;
        }
        .tst-counter span { font-weight: 700; }
        .tst-counter.is-low { color: #d97706; }
        .tst-counter.is-ok { color: #16a34a; }
        .tst-error {
            font-size: 12px;
            color: #dc2626;
            margin-top: 6px;
        }
        .tst-footer {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-top: 6px;
        }
        .tst-submit {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 26px;
            border: none;
            border-radius: 11px;
            background: linear-gradient(90deg, var(--tst-primary-dark), var(--tst-primary));
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: opacity .15s ease, transform .15s ease;
        }
        .tst-submit:hover:not(:disabled) { transform: translateY(-1px); }
        .tst-submit:disabled { opacity: .6; cursor: wait; }
        .tst-back {
            color: var(--tst-muted);
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
        }
        .tst-back:hover { color: var(--tst-primary); text-decoration: underline; }

        @media (max-width: 560px) {
            .tst-card { padding: 20px 18px; }
        }
    </style>

    {{-- ═══ HEADER ═══ --}}
    <div class="tst-header">
        <div class="breadcrumb">
            <a href="{{ route('intern.dashboard') }}">Dashboard</a>
            <i class="ti ti-chevron-right"></i>
            <span>Testimoni</span>
        </div>
        <h2 class="tst-title">Testimoni</h2>
        <p class="tst-sub">Bagikan pengalaman Anda mengikuti program magang/PKL</p>
    </div>

    <div class="tst-wrap">
        @if(!$hasCompletedInternship)
            <div class="tst-empty">
                <div class="tst-empty-icon"><i class="ti ti-message-star"></i></div>
                <h3 class="tst-empty-title">Testimoni</h3>
                <p class="tst-empty-sub">Testimoni hanya bisa diisi setelah magang selesai.</p>
            </div>
        @elseif($submitted || $alreadySubmitted)
            <div class="tst-success">
                <div class="tst-success-icon"><i class="ti ti-check"></i></div>
                <h3 class="tst-success-title">Testimoni Terkirim</h3>
                <p class="tst-success-desc">Terima kasih! Testimoni Anda telah dikirim dan menunggu persetujuan admin untuk ditayangkan.</p>

                @if($content)
                    <div class="tst-preview">
                        <div class="tst-preview-stars">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="ti ti-star{{ $i <= $rating ? '-filled' : '' }} {{ $i > $rating ? 'off' : '' }}"></i>
                            @endfor
                        </div>
                        <p class="tst-preview-text">"{{ $content }}"</p>
                    </div>
                @endif

                <a href="{{ route('intern.dashboard') }}" wire:navigate class="tst-success-back">
                    <i class="ti ti-arrow-left"></i> Kembali ke Dashboard
                </a>
            </div>
        @else
            <div class="tst-card">
                <h3 class="tst-card-title">Berikan Testimoni</h3>
                <p class="tst-card-sub">Ceritakan pengalaman dan kesan Anda selama magang/PKL</p>

                <form wire:submit="submit">
                    <div class="tst-field">
                        <label class="tst-label">Rating <span class="tst-required">*</span></label>
                        <div class="tst-stars">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button" wire:click="$set('rating', {{ $i }})" class="tst-star {{ $i <= $rating ? 'on' : '' }}" aria-label="{{ $i }} dari 5 bintang">
                                    <i class="ti ti-star{{ $i <= $rating ? '-filled' : '' }}"></i>
                                </button>
                            @endfor
                        </div>
                        <p class="tst-star-label">{{ $rating }}/5 bintang</p>
                        @error('rating') <div class="tst-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="tst-field">
                        <label class="tst-label">Testimoni <span class="tst-required">*</span></label>
                        <textarea
                            x-data="{ len: {{ Str::length($content) }} }"
                            @input="len = $el.value.length"
                            wire:model="content"
                            rows="5"
                            class="tst-input"
                            placeholder="Ceritakan pengalaman Anda..."
                        ></textarea>
                        <div class="tst-counter" x-show="len > 0" x-cloak>
                            <span x-text="len" x-bind:class="len >= 20 ? 'is-ok' : 'is-low'"></span>
                            <span x-show="len < 20"> / Minimal 20 karakter</span>
                            <span x-show="len >= 20"> / 1000</span>
                        </div>
                        @error('content') <div class="tst-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="tst-footer">
                        <button type="submit" wire:loading.attr="disabled" class="tst-submit">
                            <i wire:loading.remove class="ti ti-send"></i>
                            <span wire:loading.remove>Kirim Testimoni</span>
                            <span wire:loading class="inline-flex items-center gap-1">
                                <i class="ti ti-loader animate-spin"></i>
                                Mengirim...
                            </span>
                        </button>
                        <a href="{{ route('intern.dashboard') }}" wire:navigate class="tst-back">Kembali</a>
                    </div>
                </form>
            </div>
        @endif
    </div>
</div>