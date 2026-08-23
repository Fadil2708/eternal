<div>
    <div class="sdv-stat-grid">
        <div class="sdv-stat">
            <div class="sdv-stat-icon is-blue"><i class="ti ti-users"></i></div>
            <div>
                <div class="sdv-stat-value">{{ $totalInterns }}</div>
                <div class="sdv-stat-label">Peserta Bimbingan</div>
            </div>
        </div>
        <div class="sdv-stat">
            <div class="sdv-stat-icon is-amber"><i class="ti ti-notebook"></i></div>
            <div>
                <div class="sdv-stat-value">{{ $pendingLogbooks }}</div>
                <div class="sdv-stat-label">Logbook Perlu Review</div>
            </div>
        </div>
        <div class="sdv-stat">
            <div class="sdv-stat-icon is-blue"><i class="ti ti-file-description"></i></div>
            <div>
                <div class="sdv-stat-value">{{ $pendingReports }}</div>
                <div class="sdv-stat-label">Laporan Akhir Menunggu</div>
            </div>
        </div>
        <div class="sdv-stat">
            <div class="sdv-stat-icon is-green"><i class="ti ti-circle-check"></i></div>
            <div>
                <div class="sdv-stat-value">{{ $approvedLogbooks }}</div>
                <div class="sdv-stat-label">Logbook Disetujui</div>
            </div>
        </div>
    </div>

    @if($totalLogbooks > 0)
        @php
            $approvedPct = round(($approvedLogbooks / $totalLogbooks) * 100);
            $pendingPct = round(($pendingLogbooks / $totalLogbooks) * 100);
            $revisionPct = round(($revisionLogbooks / $totalLogbooks) * 100);
            $otherPct = 100 - $approvedPct - $pendingPct - $revisionPct;
        @endphp
        <div class="sdv-card">
            <div class="sdv-card-head">
                <h3 class="sdv-card-title">Progress Logbook</h3>
            </div>
            <div class="sdv-bar">
                @if($approvedPct > 0) <div class="sdv-bar-seg" style="width:{{ $approvedPct }}%;background:#16A34A"></div> @endif
                @if($pendingPct > 0) <div class="sdv-bar-seg" style="width:{{ $pendingPct }}%;background:#D97706"></div> @endif
                @if($revisionPct > 0) <div class="sdv-bar-seg" style="width:{{ $revisionPct }}%;background:#DC2626"></div> @endif
                @if($otherPct > 0) <div class="sdv-bar-seg" style="width:{{ $otherPct }}%;background:#E2E8F0"></div> @endif
            </div>
            <div class="sdv-legend">
                <div class="sdv-legend-item">
                    <span class="sdv-legend-dot" style="background:#16A34A"></span>
                    <div>
                        <span class="sdv-legend-name">Disetujui</span>
                        <span class="sdv-legend-count">{{ $approvedLogbooks }} ({{ $approvedPct }}%)</span>
                    </div>
                </div>
                <div class="sdv-legend-item">
                    <span class="sdv-legend-dot" style="background:#D97706"></span>
                    <div>
                        <span class="sdv-legend-name">Perlu Review</span>
                        <span class="sdv-legend-count">{{ $pendingLogbooks }} ({{ $pendingPct }}%)</span>
                    </div>
                </div>
                <div class="sdv-legend-item">
                    <span class="sdv-legend-dot" style="background:#DC2626"></span>
                    <div>
                        <span class="sdv-legend-name">Revisi</span>
                        <span class="sdv-legend-count">{{ $revisionLogbooks }} ({{ $revisionPct }}%)</span>
                    </div>
                </div>
                <div class="sdv-legend-item">
                    <span class="sdv-legend-dot" style="background:#E2E8F0"></span>
                    <div>
                        <span class="sdv-legend-name">Draft/Lainnya</span>
                        <span class="sdv-legend-count">{{ $totalLogbooks - $approvedLogbooks - $pendingLogbooks - $revisionLogbooks }} ({{ $otherPct }}%)</span>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>