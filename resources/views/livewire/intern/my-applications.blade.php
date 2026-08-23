<div>
    {{-- ===== HERO RINGAN ===== --}}
    <div class="vc-hero">
        <div class="vc-hero-main">
            <div class="breadcrumb">
                <a href="{{ route('intern.dashboard') }}">Dashboard</a>
                <i class="ti ti-chevron-right"></i>
                <span>Lamaran</span>
            </div>
            <h1 class="vc-hero-title">Lamaran Saya</h1>
            <p class="vc-hero-sub">Pantau status lamaran magang yang telah dikirim</p>
        </div>
        <div class="vc-hero-stats">
            <span class="stat-chip">
                <i class="ti ti-file-description"></i>
                <strong>{{ $totalCount }}</strong> lamaran
            </span>
            <span class="stat-chip">
                <i class="ti ti-hourglass-high"></i>
                <strong>{{ $activeCount }}</strong> diproses
            </span>
            <span class="stat-chip stat-chip-accent">
                <i class="ti ti-circle-check"></i>
                <strong>{{ $acceptedCount }}</strong> diterima
            </span>
        </div>
    </div>

    {{-- ===== FILTER BAR ===== --}}
    <div class="filter-bar vc-toolbar">
        <div class="filter-tabs ap-tabs hide-mobile">
            <button wire:click="$set('filterStatus', '')" class="filter-tab {{ $filterStatus === '' ? 'active' : '' }}">Semua</button>
            <button wire:click="$set('filterStatus', 'submitted')" class="filter-tab {{ $filterStatus === 'submitted' ? 'active' : '' }}">Terkirim
                @if(($statusCounts['submitted'] ?? 0) > 0)<span class="filter-count">{{ $statusCounts['submitted'] }}</span>@endif
            </button>
            <button wire:click="$set('filterStatus', 'under_review')" class="filter-tab {{ $filterStatus === 'under_review' ? 'active' : '' }}">Direview
                @if(($statusCounts['under_review'] ?? 0) > 0)<span class="filter-count">{{ $statusCounts['under_review'] }}</span>@endif
            </button>
            <button wire:click="$set('filterStatus', 'interview_scheduled')" class="filter-tab {{ $filterStatus === 'interview_scheduled' ? 'active' : '' }}">Interview
                @if(($statusCounts['interview_scheduled'] ?? 0) > 0)<span class="filter-count">{{ $statusCounts['interview_scheduled'] }}</span>@endif
            </button>
            <button wire:click="$set('filterStatus', 'accepted')" class="filter-tab {{ $filterStatus === 'accepted' ? 'active' : '' }}">Diterima
                @if(($statusCounts['accepted'] ?? 0) > 0)<span class="filter-count">{{ $statusCounts['accepted'] }}</span>@endif
            </button>
            <button wire:click="$set('filterStatus', 'rejected')" class="filter-tab {{ $filterStatus === 'rejected' ? 'active' : '' }}">Ditolak
                @if(($statusCounts['rejected'] ?? 0) > 0)<span class="filter-count">{{ $statusCounts['rejected'] }}</span>@endif
            </button>
            <button wire:click="$set('filterStatus', 'cancelled')" class="filter-tab {{ $filterStatus === 'cancelled' ? 'active' : '' }}">Dibatalkan
                @if(($statusCounts['cancelled'] ?? 0) > 0)<span class="filter-count">{{ $statusCounts['cancelled'] }}</span>@endif
            </button>
        </div>
        <div class="filter-select-wrap show-mobile">
            <i class="ti ti-filter"></i>
            <select wire:change="$set('filterStatus', $event.target.value)" class="filter-select">
                <option value="">Semua</option>
                <option value="submitted">Terkirim</option>
                <option value="under_review">Direview</option>
                <option value="interview_scheduled">Interview</option>
                <option value="accepted">Diterima</option>
                <option value="rejected">Ditolak</option>
                <option value="cancelled">Dibatalkan</option>
            </select>
        </div>
        <span class="result-count">Menampilkan {{ $applications->total() }} lamaran</span>
    </div>

    {{-- ===== SKELETON ===== --}}
    <div wire:loading class="ap-list">
        @for($i = 0; $i < 3; $i++)
        <div class="panel ap-card ap-skeleton">
            <div class="ap-card-head">
                <div class="skeleton ap-sk-avatar"></div>
                <div style="flex:1">
                    <div class="skeleton-text skeleton-text-lg" style="width:55%;margin-bottom:8px"></div>
                    <div class="skeleton-text skeleton-text-sm" style="width:35%"></div>
                </div>
            </div>
            <div class="skeleton" style="width:100%;height:6px;border-radius:6px;margin:4px 0 10px"></div>
            <div class="skeleton" style="width:70%;height:6px;border-radius:6px;margin-bottom:14px"></div>
            <div class="skeleton" style="width:100%;height:36px;border-radius:10px"></div>
        </div>
        @endfor
    </div>

    {{-- ===== LIST LAMARAN ===== --}}
    <div wire:loading.remove class="ap-list">
        @forelse($applications as $app)
            @php
                $canCancel = in_array($app->status, ['submitted', 'under_review', 'interview_scheduled'], true);
                $stepStatuses = ['submitted', 'under_review', 'interview_scheduled'];
                $currentStep = $canCancel ? array_search($app->status, $stepStatuses, true) : -1;
            @endphp
            <article class="panel ap-card" aria-label="Lamaran {{ $app->vacancy->title }}">
                <div class="ap-card-head">
                    <div class="ap-avatar ap-st-{{ $app->status }}">
                        <i class="ti ti-briefcase"></i>
                    </div>
                    <div class="ap-card-main">
                        <a href="{{ route('intern.applications.show', $app) }}" class="ap-card-title">{{ $app->vacancy->title }}</a>
                        <p class="ap-card-meta">{{ $app->vacancy->division }} &mdash; Dikirim {{ $app->applied_at?->diffForHumans() ?? '—' }}</p>
                    </div>
                    <x-badge status="{{ $app->status }}" />
                </div>

                @if($canCancel)
                    <ol class="ap-stepper" aria-label="Progres lamaran">
                        @foreach($stepStatuses as $i => $step)
                            @php
                                $state = $i < $currentStep ? 'done' : ($i === $currentStep ? 'active' : '');
                            @endphp
                            <li class="ap-step {{ $state ? 'ap-step-' . $state : '' }}">
                                <span class="ap-step-dot">
                                    @if($i < $currentStep)
                                        <i class="ti ti-check"></i>
                                    @else
                                        {{ $i + 1 }}
                                    @endif
                                </span>
                                <span class="ap-step-label">{{ ['submitted' => 'Terkirim', 'under_review' => 'Direview', 'interview_scheduled' => 'Interview'][$step] }}</span>
                            </li>
                        @endforeach
                    </ol>
                @endif

                @if($app->status === 'accepted')
                    <div class="ap-note ap-note-success">
                        <i class="ti ti-circle-check"></i>
                        <span>Selamat, lamaran kamu diterima!</span>
                    </div>
                @elseif($app->status === 'rejected' && $app->rejection_reason)
                    <div class="ap-note ap-note-danger">
                        <i class="ti ti-alert-triangle"></i>
                        <span>Alasan: {{ $app->rejection_reason }}</span>
                    </div>
                @elseif($app->status === 'cancelled')
                    <div class="ap-note ap-note-muted">
                        <i class="ti ti-x"></i>
                        <span>Lamaran dibatalkan.</span>
                    </div>
                @endif

                @if($app->status === 'interview_scheduled' && $app->interview_date)
                    <div class="ap-note ap-note-violet">
                        <i class="ti ti-calendar-time"></i>
                        <span>Interview dijadwalkan: {{ $app->interview_date->format('d M Y H:i') }}</span>
                    </div>
                @endif

                @if($app->admin_notes)
                    <div class="ap-note ap-note-neutral">
                        <i class="ti ti-message-circle"></i>
                        <span><strong>Catatan Admin:</strong> {{ $app->admin_notes }}</span>
                    </div>
                @endif

                @if($canCancel)
                    <div class="ap-card-foot">
                        <button wire:click="confirmCancel('{{ $app->id }}')"
                                wire:loading.attr="disabled" wire:loading.class="opacity-60 cursor-wait"
                                class="btn-cancel">
                            <i class="ti ti-x"></i> Batalkan Lamaran
                        </button>
                    </div>
                @endif
            </article>
        @empty
            <div class="vc-empty">
                <div class="vc-empty-icon">
                    <i class="ti ti-file-description"></i>
                </div>
                <h3 class="vc-empty-title">
                    @if($filterStatus)
                        Tidak ada lamaran dengan status ini
                    @else
                        Belum ada lamaran
                    @endif
                </h3>
                <p class="vc-empty-sub">
                    @if($filterStatus)
                        Coba pilih status lain untuk melihat daftar lamaran.
                    @else
                        Kamu belum mengirim lamaran magang. Cari lowongan yang cocok dan mulai daftar.
                    @endif
                </p>
                @if($filterStatus)
                    <button wire:click="$set('filterStatus', '')" class="btn-secondary vc-empty-btn">
                        <i class="ti ti-refresh"></i> Tampilkan Semua
                    </button>
                @else
                    <a href="{{ route('intern.vacancies') }}" class="btn-primary vc-empty-btn">
                        <i class="ti ti-briefcase"></i> Lihat Lowongan
                    </a>
                @endif
            </div>
        @endforelse
    </div>

    <div class="pagination-wrap">
        {{ $applications->links('components.pagination', ['paginator' => $applications]) }}
    </div>

    @if($confirmingCancelId)
    <div class="modal-wrap" aria-labelledby="modal-title" role="dialog" aria-modal="true"
         x-data
         @keydown.escape.window="$wire.set('confirmingCancelId', null)">
        <div class="modal-backdrop" @click="$wire.set('confirmingCancelId', null)"></div>
        <div class="modal-center">
            <div class="modal-card modal-card-md">
                <div class="modal-header">
                    <h3 class="modal-title">Konfirmasi Pembatalan</h3>
                </div>
                <div class="modal-body">
                    <p class="text-body-sm" style="color:#5C5A55">Yakin ingin membatalkan lamaran ini? Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="modal-footer">
                    <button wire:click="$set('confirmingCancelId', null)" class="btn-secondary">Batal</button>
                    <button wire:click="cancel"
                            wire:loading.attr="disabled" wire:loading.class="opacity-60 cursor-wait"
                            class="btn-save">
                        <span wire:loading.remove>Ya, Batalkan</span>
                        <span wire:loading class="inline-flex items-center gap-1">
                            <i class="ti ti-loader animate-spin"></i>
                            Memproses...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>