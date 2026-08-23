<div class="adx-root">
    {{-- ═══ HEADER ═══ --}}
    <div class="adx-header">
        <div>
            <div class="breadcrumb">
                <a href="{{ route('admin.dashboard') }}" wire:navigate>Dashboard</a>
                <i class="ti ti-chevron-right"></i>
                <span>Sertifikat</span>
            </div>
            <h2 class="adx-title">Kelola Sertifikat</h2>
            <p class="adx-sub">Terbitkan dan kelola sertifikat peserta magang</p>
        </div>

        <div class="adx-header-right">
            <a href="{{ route('admin.export.certificates') }}" class="adx-btn adx-btn-ghost">
                <i class="ti ti-download"></i> Export
            </a>
        </div>
    </div>

    {{-- ═══ PENDING ISSUANCE ═══ --}}
    @if($completedInternships->isNotEmpty())
    <div class="adx-card" style="margin-bottom:20px;border-left:4px solid var(--adx-amber);background:var(--adx-amber-bg)">
        <div style="padding:16px 20px">
            <h3 style="font-size:13px;font-weight:700;color:var(--adx-amber);margin:0 0 14px;display:flex;align-items:center;gap:8px">
                <i class="ti ti-alert-triangle"></i> Magang Selesai — Menunggu Penerbitan Sertifikat
            </h3>
            <div style="display:flex;flex-direction:column;gap:8px">
                @foreach($completedInternships as $internship)
                <div class="adx-card" style="padding:12px 16px;display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap">
                    <div style="display:flex;align-items:center;gap:10px;min-width:0">
                        @php $pName = $internship->intern->internProfile->full_name ?? $internship->intern->email; @endphp
                        <x-avatar name="{{ $pName }}" size="32" type="r" />
                        <div style="min-width:0">
                            <div style="font-size:13px;font-weight:600;color:var(--adx-text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $pName }}</div>
                            <div style="font-size:12px;color:var(--adx-muted)">{{ $internship->vacancy->title }}</div>
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:10px;flex-shrink:0">
                        @if($internship->evaluation)
                            <span style="font-size:12px;color:var(--adx-muted)">Nilai: <strong style="color:var(--adx-text)">{{ number_format($internship->evaluation->final_score, 0) }}</strong></span>
                        @else
                            <span style="font-size:12px;color:var(--adx-red);font-style:italic">Belum dinilai</span>
                        @endif
                        <button wire:click="confirmIssue('{{ $internship->id }}')"
                                wire:loading.attr="disabled" wire:loading.class="opacity-60 cursor-wait"
                                @disabled(!$internship->evaluation)
                                class="adx-btn adx-btn-primary" style="padding:6px 14px;font-size:12px">
                            Terbitkan
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- ═══ TOOLBAR ═══ --}}
    <div class="adx-toolbar">
        <div class="adx-search">
            <i class="ti ti-search"></i>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama atau nomor sertifikat...">
        </div>

        <div class="adx-filter-tabs" role="tablist" aria-label="Filter grade">
            <button wire:click="$set('filterGrade', '')" class="adx-filter-tab {{ $filterGrade === '' ? 'active' : '' }}">
                Semua <span class="adx-filter-count">{{ $gradeCounts['total'] ?? 0 }}</span>
            </button>
            <button wire:click="$set('filterGrade', 'A')" class="adx-filter-tab {{ $filterGrade === 'A' ? 'active' : '' }}">
                A <span class="adx-filter-count">{{ $gradeCounts['A'] ?? 0 }}</span>
            </button>
            <button wire:click="$set('filterGrade', 'B')" class="adx-filter-tab {{ $filterGrade === 'B' ? 'active' : '' }}">
                B <span class="adx-filter-count">{{ $gradeCounts['B'] ?? 0 }}</span>
            </button>
            <button wire:click="$set('filterGrade', 'C')" class="adx-filter-tab {{ $filterGrade === 'C' ? 'active' : '' }}">
                C <span class="adx-filter-count">{{ $gradeCounts['C'] ?? 0 }}</span>
            </button>
            <button wire:click="$set('filterGrade', 'D')" class="adx-filter-tab {{ $filterGrade === 'D' ? 'active' : '' }}">
                D <span class="adx-filter-count">{{ $gradeCounts['D'] ?? 0 }}</span>
            </button>
        </div>
    </div>

    {{-- ═══ TABLE ═══ --}}
    <div class="adx-card adx-table-card">
        <div class="adx-table-scroll">
            <table class="adx-table">
                <thead>
                    <tr>
                        <th>Peserta</th>
                        <th>No. Sertifikat</th>
                        <th>Nilai</th>
                        <th>Grade</th>
                        <th>Tgl Terbit</th>
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
                                    <div class="skeleton-text skeleton-text-sm" style="width:180px;margin-bottom:0"></div>
                                </div>
                            </div>
                        </td>
                        <td><div class="skeleton-text skeleton-text-sm" style="width:130px;margin-bottom:0"></div></td>
                        <td><div class="skeleton-text" style="width:40px"></div></td>
                        <td><div class="skeleton" style="width:36px;height:24px;border-radius:20px"></div></td>
                        <td><div class="skeleton-text skeleton-text-sm" style="width:100px;margin-bottom:0"></div></td>
                        <td class="text-right"><div class="skeleton" style="width:32px;height:32px;border-radius:9px;margin-left:auto"></div></td>
                    </tr>
                    @endfor
                </tbody>
                <tbody wire:loading.remove>
                    @forelse($certificates as $cert)
                    <tr wire:key="cert-{{ $cert->id }}">
                        <td>
                            <div class="adx-table-user">
                                @php $certName = $cert->intern->internProfile->full_name ?? $cert->intern->email; @endphp
                                <x-avatar name="{{ $certName }}" size="36" type="r" />
                                <div>
                                    <div class="adx-table-name">{{ $certName }}</div>
                                    <div class="adx-table-email">{{ $cert->intern->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td><span style="font-size:12px;color:var(--adx-muted);font-family:monospace">{{ $cert->certificate_number }}</span></td>
                        <td><span style="font-weight:700;color:var(--adx-text)">{{ number_format($cert->final_score, 0) }}</span></td>
                        <td>
                            <span class="adx-chip adx-chip-grade-{{ $cert->grade }}">{{ $cert->grade }}</span>
                        </td>
                        <td><span class="adx-date">{{ $cert->issued_at ? $cert->issued_at->format('d M Y') : '-' }}</span></td>
                        <td class="text-right">
                            @if($cert->certificate_file_url)
                            <a href="{{ route('admin.certificates.download', $cert->id) }}" class="adx-action is-success" title="Download">
                                <i class="ti ti-download"></i>
                            </a>
                            @else
                            <span style="font-size:11px;color:var(--adx-muted);font-style:italic">Menunggu PDF</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <x-empty-state icon="ti-certificate" message="Belum ada sertifikat." />
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $certificates->links('components.pagination', ['paginator' => $certificates]) }}

    {{-- ═══ ISSUE CONFIRMATION MODAL ═══ --}}
    @if($confirmingIssueId)
    <div class="modal-wrap" aria-labelledby="modal-title" role="dialog" aria-modal="true"
         x-data
         @keydown.escape.window="$wire.set('confirmingIssueId', null)">
        <div class="modal-backdrop" @click="$wire.set('confirmingIssueId', null)"></div>
        <div class="modal-center">
            <div class="modal-card modal-card-md">
                <div class="modal-header">
                    <h3 id="modal-title" class="modal-title">Konfirmasi Penerbitan</h3>
                    <button wire:click="$set('confirmingIssueId', null)" class="adx-action" aria-label="Tutup modal">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <div class="modal-body" style="text-align:center;padding:24px">
                    <div class="adx-modal-icon is-success">
                        <i class="ti ti-certificate"></i>
                    </div>
                    <p class="adx-modal-text">
                        Yakin ingin <strong>menerbitkan sertifikat</strong> untuk peserta ini?
                    </p>
                </div>
                <div class="modal-footer">
                    <button wire:click="$set('confirmingIssueId', null)" class="adx-btn adx-btn-ghost">Batal</button>
                    <button wire:click="issue"
                            wire:loading.attr="disabled" wire:loading.class="opacity-60 cursor-wait"
                            class="adx-btn adx-btn-primary">
                        <span wire:loading.remove><i class="ti ti-certificate" style="margin-right:6px"></i>Ya, Terbitkan</span>
                        <span wire:loading class="inline-flex items-center gap-1">
                            <i class="ti ti-loader animate-spin"></i> Memproses...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
