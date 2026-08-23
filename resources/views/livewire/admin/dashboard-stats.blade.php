<div>
    {{-- ═══ STAT CARDS ═══ --}}
    <div wire:loading class="adx-stat-grid">
        @for($i = 0; $i < 6; $i++)
        <div class="adx-stat">
            <div class="skeleton" style="width:46px;height:46px;border-radius:13px;flex-shrink:0"></div>
            <div style="flex:1;min-width:0">
                <div class="skeleton-text skeleton-text-lg" style="width:55%"></div>
                <div class="skeleton-text skeleton-text-sm" style="width:75%;margin-bottom:0"></div>
            </div>
        </div>
        @endfor
    </div>

    <div wire:loading.remove class="contents">

        <div class="adx-stat-grid">
            <div class="adx-stat">
                <div class="adx-stat-icon is-blue"><i class="ti ti-users"></i></div>
                <div>
                    <div class="adx-stat-value">{{ $totalInternsActive }}</div>
                    <div class="adx-stat-label">Magang Aktif</div>
                </div>
            </div>

            <div class="adx-stat">
                <div class="adx-stat-icon is-amber"><i class="ti ti-building"></i></div>
                <div>
                    <div class="adx-stat-value">{{ $totalVacanciesOpen }}</div>
                    <div class="adx-stat-label">Lowongan Buka</div>
                </div>
            </div>

            <div class="adx-stat">
                <div class="adx-stat-icon is-green"><i class="ti ti-file-description"></i></div>
                <div>
                    <div class="adx-stat-value">{{ $totalApplicationsPending }}</div>
                    <div class="adx-stat-label">Lamaran Baru</div>
                </div>
            </div>

            <div class="adx-stat">
                <div class="adx-stat-icon is-amber"><i class="ti ti-notebook"></i></div>
                <div>
                    <div class="adx-stat-value">{{ $totalLogbooksPending }}</div>
                    <div class="adx-stat-label">Logbook Pending</div>
                </div>
            </div>

            <div class="adx-stat">
                <div class="adx-stat-icon is-green"><i class="ti ti-certificate"></i></div>
                <div>
                    <div class="adx-stat-value">{{ $certificatesThisMonth }}</div>
                    <div class="adx-stat-label">Sertifikat Bulan Ini</div>
                </div>
            </div>

            <div class="adx-stat">
                <div class="adx-stat-icon is-blue"><i class="ti ti-clipboard-list"></i></div>
                <div>
                    <div class="adx-stat-value">{{ $totalInternsActive + $certificatesThisMonth }}</div>
                    <div class="adx-stat-label">Total Aktivitas</div>
                </div>
            </div>
        </div>

        {{-- ═══ TREND + STATUS ═══ --}}
        <div class="adx-chart-grid">
            <div class="adx-card adx-card-chart">
                <div class="adx-card-head">
                    <h3 class="adx-card-title">Tren Lamaran</h3>
                    <span class="adx-card-meta">Total: {{ array_sum($monthlyApplications) }} lamaran</span>
                </div>
                @php $maxVal = max(1, max($monthlyApplications)); @endphp
                <div class="adx-chart-bars">
                    @foreach($monthlyLabels as $idx => $label)
                    <div class="adx-chart-bar-wrap">
                        <span class="adx-chart-bar-value">{{ $monthlyApplications[$idx] }}</span>
                        <div class="adx-chart-bar-track">
                            <div class="adx-chart-bar" style="height: {{ max(4, ($monthlyApplications[$idx] / $maxVal) * 100) }}%"></div>
                        </div>
                        <span class="adx-chart-bar-label">{{ $label }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="adx-card">
                <h3 class="adx-card-title">Status Magang</h3>
                @php
                    $totalStat = max(1, $totalInternships);
                    $activePct = round(($totalInternsActive / $totalStat) * 100);
                    $completedPct = round(($completedInternships / $totalStat) * 100);
                    $terminatedPct = round(($terminatedInternships / $totalStat) * 100);
                    $quotaPct = $totalQuota > 0 ? min(round(($activeInternships / $totalQuota) * 100), 100) : 0;
                @endphp
                <div class="adx-bar">
                    @if($activePct > 0) <div class="adx-bar-seg" style="width:{{ $activePct }}%;background:#3155E7"></div> @endif
                    @if($completedPct > 0) <div class="adx-bar-seg" style="width:{{ $completedPct }}%;background:#16A34A"></div> @endif
                    @if($terminatedPct > 0) <div class="adx-bar-seg" style="width:{{ $terminatedPct }}%;background:#DC2626"></div> @endif
                </div>
                <div class="adx-legend">
                    <div class="adx-legend-item">
                        <span class="adx-legend-dot" style="background:#3155E7"></span>
                        <div>
                            <span class="adx-legend-name">Aktif</span>
                            <span class="adx-legend-count">{{ $totalInternsActive }} ({{ $activePct }}%)</span>
                        </div>
                    </div>
                    <div class="adx-legend-item">
                        <span class="adx-legend-dot" style="background:#16A34A"></span>
                        <div>
                            <span class="adx-legend-name">Selesai</span>
                            <span class="adx-legend-count">{{ $completedInternships }} ({{ $completedPct }}%)</span>
                        </div>
                    </div>
                    <div class="adx-legend-item">
                        <span class="adx-legend-dot" style="background:#DC2626"></span>
                        <div>
                            <span class="adx-legend-name">Terminasi</span>
                            <span class="adx-legend-count">{{ $terminatedInternships }} ({{ $terminatedPct }}%)</span>
                        </div>
                    </div>
                    <div class="adx-legend-item">
                        <span class="adx-legend-dot" style="background:#D97706"></span>
                        <div>
                            <span class="adx-legend-name">Kuota Terisi</span>
                            <span class="adx-legend-count">{{ $activeInternships }} / {{ $totalQuota }}</span>
                        </div>
                    </div>
                </div>
                <div class="adx-progress">
                    <div class="adx-progress-track">
                        <div class="adx-progress-bar" style="width:{{ $quotaPct }}%;background:#D97706"></div>
                    </div>
                    <span class="adx-progress-label">{{ $quotaPct }}% kuota terisi</span>
                </div>
            </div>
        </div>

    </div>
</div>