<div>
    {{-- PROGRESS PROGRAM --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title">Progress Program</span>
            <select wire:model.live="range" style="border:1px solid #e2e6ed;border-radius:7px;padding:7px 10px;font-size:11px;color:#667085;">
                <option value="30">30 Hari Terakhir</option>
                <option value="7">7 Hari Terakhir</option>
                <option value="all">Semua Waktu</option>
            </select>
        </div>
        <div class="progress-list">
            <div class="progress-item">
                <div class="progress-label">
                    <span class="progress-name">
                        <span class="mini-icon" style="background:#ecfdf5;color:#059669;"><i class="ti ti-notebook"></i></span>
                        Logbook
                    </span>
                    <span class="progress-pct">{{ $logbookPct }}%</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width:{{ $logbookPct }}%;background:#059669;"></div>
                </div>
                <div class="progress-caption">{{ $logbookLabel }}</div>
            </div>
            <div class="progress-item">
                <div class="progress-label">
                    <span class="progress-name">
                        <span class="mini-icon" style="background:#edf2ff;color:#3155e7;"><i class="ti ti-file-report"></i></span>
                        Laporan
                    </span>
                    <span class="progress-pct">{{ $reportPct }}%</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width:{{ $reportPct }}%;background:#3155e7;"></div>
                </div>
                <div class="progress-caption">{{ $reportLabel }}</div>
            </div>
            <div class="progress-item">
                <div class="progress-label">
                    <span class="progress-name">
                        <span class="mini-icon" style="background:#fff7ed;color:#ea580c;"><i class="ti ti-message-circle"></i></span>
                        Bimbingan
                    </span>
                    <span class="progress-pct">{{ $guidancePct }}%</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width:{{ $guidancePct }}%;background:#f59e0b;"></div>
                </div>
                <div class="progress-caption">{{ $guidanceLabel }}</div>
            </div>
            <div class="progress-item">
                <div class="progress-label">
                    <span class="progress-name">
                        <span class="mini-icon" style="background:#f4f0ff;color:#7c3aed;"><i class="ti ti-clock"></i></span>
                        Absensi
                    </span>
                    <span class="progress-pct">{{ $attendancePct }}%</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width:{{ $attendancePct }}%;background:#7c3aed;"></div>
                </div>
                <div class="progress-caption">{{ $attendanceLabel }}</div>
            </div>
            @if(! $hasInternship)
                <p class="progress-caption" style="margin-top:8px;color:#98a2b3;">Belum ada program magang aktif untuk diukur.</p>
            @endif
        </div>
    </div>
</div>