<div class="adx-root">
    @php
        $appStatusLabels = [
            'submitted' => 'Terkirim',
            'under_review' => 'Direview',
            'interview_scheduled' => 'Interview',
            'accepted' => 'Diterima',
            'rejected' => 'Ditolak',
            'cancelled' => 'Dibatalkan',
        ];
    @endphp

    {{-- ═══ HEADER ═══ --}}
    <div class="adx-header">
        <div>
            <div class="breadcrumb">
                <a href="{{ route('admin.dashboard') }}" wire:navigate>Dashboard</a>
                <i class="ti ti-chevron-right"></i>
                <span>Lamaran</span>
            </div>
            <h2 class="adx-title">Review Lamaran</h2>
            <p class="adx-sub">Tinjau dan proses lamaran masuk dari peserta</p>
        </div>

        <div class="adx-header-right">
            <a href="{{ route('admin.export.applications') }}" wire:navigate class="adx-btn adx-btn-ghost">
                <i class="ti ti-download"></i> Export
            </a>
        </div>
    </div>

    {{-- ═══ TOOLBAR ═══ --}}
    <div class="adx-toolbar">
        <div class="adx-filter-tabs" role="tablist" aria-label="Filter status">
            <button wire:click="$set('filterStatus', '')" class="adx-filter-tab {{ $filterStatus === '' ? 'active' : '' }}">
                Semua <span class="adx-filter-count">{{ $statusCounts['total'] }}</span>
            </button>
            <button wire:click="$set('filterStatus', 'submitted')" class="adx-filter-tab {{ $filterStatus === 'submitted' ? 'active' : '' }}">
                Terkirim <span class="adx-filter-count">{{ $statusCounts['submitted'] }}</span>
            </button>
            <button wire:click="$set('filterStatus', 'under_review')" class="adx-filter-tab {{ $filterStatus === 'under_review' ? 'active' : '' }}">
                Direview <span class="adx-filter-count">{{ $statusCounts['under_review'] }}</span>
            </button>
            <button wire:click="$set('filterStatus', 'interview_scheduled')" class="adx-filter-tab {{ $filterStatus === 'interview_scheduled' ? 'active' : '' }}">
                Interview <span class="adx-filter-count">{{ $statusCounts['interview_scheduled'] }}</span>
            </button>
            <button wire:click="$set('filterStatus', 'accepted')" class="adx-filter-tab {{ $filterStatus === 'accepted' ? 'active' : '' }}">
                Diterima <span class="adx-filter-count">{{ $statusCounts['accepted'] }}</span>
            </button>
            <button wire:click="$set('filterStatus', 'rejected')" class="adx-filter-tab {{ $filterStatus === 'rejected' ? 'active' : '' }}">
                Ditolak <span class="adx-filter-count">{{ $statusCounts['rejected'] }}</span>
            </button>
            <button wire:click="$set('filterStatus', 'cancelled')" class="adx-filter-tab {{ $filterStatus === 'cancelled' ? 'active' : '' }}">
                Dibatalkan <span class="adx-filter-count">{{ $statusCounts['cancelled'] }}</span>
            </button>
        </div>

        <div class="adx-select-wrap">
            <i class="ti ti-building-skyscraper"></i>
            <select wire:model.live="filterVacancy" class="adx-select">
                <option value="">Semua Lowongan</option>
                @foreach($vacancies as $vac)
                    <option value="{{ $vac->id }}">{{ $vac->title }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- ═══ TABLE ═══ --}}
    <div class="adx-card adx-table-card">
        <div class="adx-table-scroll">
            <table class="adx-table">
                <thead>
                    <tr>
                        <th>Pelamar</th>
                        <th>Lowongan</th>
                        <th>Tgl Daftar</th>
                        <th>Status</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody wire:loading>
                    @for($i = 0; $i < 5; $i++)
                    <tr>
                        <td>
                            <div class="adx-table-user">
                                <div class="skeleton" style="width:36px;height:36px;border-radius:50%;flex-shrink:0"></div>
                                <div>
                                    <div class="skeleton-text skeleton-text-lg" style="width:140px"></div>
                                    <div class="skeleton-text skeleton-text-sm" style="width:120px;margin-bottom:0"></div>
                                </div>
                            </div>
                        </td>
                        <td><div class="skeleton-text skeleton-text-lg" style="width:180px"></div></td>
                        <td><div class="skeleton-text skeleton-text-sm" style="width:90px;margin-bottom:0"></div></td>
                        <td><div class="skeleton" style="width:70px;height:22px;border-radius:20px"></div></td>
                        <td>
                            <div class="adx-actions">
                                <div class="skeleton" style="width:32px;height:32px;border-radius:9px"></div>
                            </div>
                        </td>
                    </tr>
                    @endfor
                </tbody>
                <tbody wire:loading.remove>
                    @forelse($applications as $app)
                    @php
                        $applicantName = $app->intern?->internProfile?->full_name ?? $app->intern?->email ?? '—';
                        $institution = $app->intern?->internProfile?->institution_name ?? '—';
                    @endphp
                    <tr>
                        <td>
                            <div class="adx-table-user">
                                <x-avatar name="{{ $applicantName }}" size="36" type="r" />
                                <div>
                                    <div class="adx-table-name">{{ $applicantName }}</div>
                                    <div class="adx-table-email">{{ $institution }}</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="adx-table-title-cell">{{ $app->vacancy?->title ?? '—' }}</span></td>
                        <td><span class="adx-date">{{ $app->applied_at?->format('d M Y') ?? '—' }}</span></td>
                        <td>
                            <span class="adx-app-chip adx-app-{{ $app->status }}">
                                {{ $appStatusLabels[$app->status] ?? ucfirst(str_replace('_', ' ', $app->status)) }}
                            </span>
                        </td>
                        <td class="text-right">
                            <div class="adx-actions">
                                <button wire:click="openReview('{{ $app->id }}')" class="adx-action" title="Review">
                                    <i class="ti ti-eye"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            @if($filterStatus || $filterVacancy)
                                <x-empty-state icon="ti-filter-off" message="Tidak ada lamaran dengan filter ini." />
                            @else
                                <x-empty-state icon="ti-inbox" message="Belum ada lamaran masuk." />
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $applications->links('components.pagination', ['paginator' => $applications]) }}

    @if($showReviewModal && $selectedApplication)
    @php $profile = $selectedApplication->intern->internProfile ?? null; @endphp
    <div class="modal-wrap" aria-labelledby="modal-title" role="dialog" aria-modal="true"
         x-data
         @keydown.escape.window="$wire.set('showReviewModal', false)">
        <div class="modal-backdrop" @click="$wire.set('showReviewModal', false)"></div>
        <div class="modal-center" style="align-items:flex-start;padding-top:48px">
            <div class="modal-card modal-card-xl adx-review-modal" style="max-height:90vh;overflow-y:auto">
                <div class="modal-header">
                    <h3 id="modal-title" class="modal-title">Review Lamaran</h3>
                    <button wire:click="$set('showReviewModal', false)" class="adx-action" aria-label="Tutup modal">
                        <i class="ti ti-x"></i>
                    </button>
                </div>

                <div class="adx-review-body">
                    <div class="adx-review-top">
                        <div class="adx-review-photo-wrap">
                            @if($profile && $profile->photo_url)
                                <img src="{{ route('admin.applications.file', [$selectedApplicationId, 'photo']) }}"
                                     alt="Foto {{ $profile->full_name }}" loading="lazy" width="120" height="120"
                                     class="adx-review-photo">
                            @else
                                <x-avatar name="{{ $profile->full_name ?? $selectedApplication->intern->email }}" size="120" type="r" fontSize="40" />
                            @endif
                            <div class="adx-review-name">{{ $profile->full_name ?? $selectedApplication->intern->email }}</div>
                            <div class="adx-review-email">{{ $selectedApplication->intern->email }}</div>
                        </div>

                        <div class="adx-review-info">
                            @if($profile)
                            <div class="adx-review-grid">
                                <div>
                                    <span class="adx-review-label">Institusi</span>
                                    <p class="adx-review-value">{{ $profile->institution_name ?? '-' }}</p>
                                </div>
                                <div>
                                    <span class="adx-review-label">Jurusan</span>
                                    <p class="adx-review-value">{{ $profile->major ?? '-' }}</p>
                                </div>
                                <div>
                                    <span class="adx-review-label">NIM/NIS</span>
                                    <p class="adx-review-value">{{ $profile->student_id ?? '-' }}</p>
                                </div>
                                <div>
                                    <span class="adx-review-label">Jenis Kelamin</span>
                                    <p class="adx-review-value">
                                        @if($profile->gender === 'male') Laki-laki
                                        @elseif($profile->gender === 'female') Perempuan
                                        @else -
                                        @endif
                                    </p>
                                </div>
                                <div>
                                    <span class="adx-review-label">No. HP</span>
                                    <p class="adx-review-value">{{ $profile->phone ?? '-' }}</p>
                                </div>
                                <div>
                                    <span class="adx-review-label">Status</span>
                                    <p class="adx-review-value">
                                        <span class="adx-app-chip adx-app-{{ $selectedApplication->status }}">
                                            {{ $appStatusLabels[$selectedApplication->status] ?? ucfirst(str_replace('_', ' ', $selectedApplication->status)) }}
                                        </span>
                                    </p>
                                </div>
                                <div style="grid-column:1 / -1">
                                    <span class="adx-review-label">Keahlian</span>
                                    <p class="adx-review-value">
                                        @if($profile->relationLoaded('skills') || $profile->skills()->exists())
                                            @foreach($profile->skills as $skill)
                                                <span class="adx-skill-badge">{{ $skill->name }}</span>
                                            @endforeach
                                        @else
                                            -
                                        @endif
                                    </p>
                                </div>
                            </div>
                            @endif
                            <div class="adx-review-section">
                                <span class="adx-review-label">Lowongan</span>
                                <p class="adx-review-value">{{ $selectedApplication->vacancy->title }}</p>
                            </div>
                            <div class="adx-review-files">
                                @if($profile && $profile->cv_url)
                                    <a href="{{ route('admin.applications.file', [$selectedApplicationId, 'cv']) }}" target="_blank"
                                       class="adx-file-btn is-success">
                                        <i class="ti ti-file-text"></i> Lihat CV
                                    </a>
                                @else
                                    <span class="adx-file-btn is-disabled">
                                        <i class="ti ti-file-x"></i> CV tidak tersedia
                                    </span>
                                @endif
                                @if($profile && $profile->cover_letter_url)
                                    <a href="{{ route('admin.applications.file', [$selectedApplicationId, 'cover-letter']) }}" target="_blank"
                                       class="adx-file-btn is-success">
                                        <i class="ti ti-mail"></i> Lihat Surat Permohonan
                                    </a>
                                @else
                                    <span class="adx-file-btn is-disabled">
                                        <i class="ti ti-mail-x"></i> Surat Permohonan tidak tersedia
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="divider">

                <div class="adx-review-body" style="padding-top:0">
                    <div class="field">
                        <label>Ubah Status</label>
                        <select wire:model.live="reviewStatus" class="input">
                            <option value="under_review">Under Review</option>
                            <option value="interview_scheduled">Jadwalkan Interview</option>
                            <option value="accepted">Terima</option>
                            <option value="rejected">Tolak</option>
                        </select>
                        @php
                            $statusLabels = [
                                'submitted' => 'Terkirim',
                                'under_review' => 'Direview',
                                'interview_scheduled' => 'Interview',
                                'accepted' => 'Diterima',
                                'rejected' => 'Ditolak',
                            ];
                        @endphp
                        <p class="text-caption" style="margin-top:4px">
                            Status saat ini: <span class="font-medium">{{ $statusLabels[$selectedApplication->status] ?? ucfirst(str_replace('_', ' ', $selectedApplication->status)) }}</span>
                        </p>
                    </div>

                    @if($reviewStatus === 'interview_scheduled')
                    <div class="field field-group">
                        <label>Tanggal Interview</label>
                        <input wire:model="interviewDate" type="datetime-local" class="input">
                    </div>
                    @endif

                    @if($reviewStatus === 'rejected')
                    <div class="field field-group">
                        <label>Alasan Penolakan <span class="required">*</span></label>
                        <textarea wire:model="rejectionReason" rows="3" class="input"></textarea>
                    </div>
                    @endif

                    <div class="field field-group">
                        <label>Catatan Admin</label>
                        <textarea wire:model="adminNotes" rows="2" class="input"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button wire:click="$set('showReviewModal', false)" class="adx-btn adx-btn-ghost">Batal</button>
                    <button wire:click="updateStatus"
                            wire:loading.attr="disabled" wire:loading.class="opacity-60 cursor-wait"
                            class="adx-btn adx-btn-primary">
                        <i wire:loading.remove class="ti ti-device-floppy"></i>
                        <span wire:loading.remove>Simpan</span>
                        <span wire:loading class="inline-flex items-center gap-1">
                            <i class="ti ti-loader animate-spin"></i>
                            Menyimpan...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>