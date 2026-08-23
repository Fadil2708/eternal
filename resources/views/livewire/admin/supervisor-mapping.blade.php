<div class="adx-root">
    {{-- ═══ HEADER ═══ --}}
    <div class="adx-header">
        <div>
            <div class="breadcrumb">
                <a href="{{ route('admin.dashboard') }}" wire:navigate>Dashboard</a>
                <i class="ti ti-chevron-right"></i>
                <span>Pembimbing</span>
            </div>
            <h2 class="adx-title">Pemetaan Pembimbing</h2>
            <p class="adx-sub">Atur pembimbing untuk setiap peserta magang</p>
        </div>
    </div>

    {{-- ═══ TOOLBAR ═══ --}}
    <div class="adx-toolbar">
        <div class="adx-search">
            <i class="ti ti-search"></i>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari peserta atau lowongan...">
        </div>

        <div class="adx-filter-tabs" role="tablist" aria-label="Filter status">
            <button wire:click="$set('filterStatus', 'active')" class="adx-filter-tab {{ $filterStatus === 'active' ? 'active' : '' }}">
                Magang Aktif <span class="adx-filter-count">{{ $statusCounts['active'] }}</span>
            </button>
            <button wire:click="$set('filterStatus', 'completed')" class="adx-filter-tab {{ $filterStatus === 'completed' ? 'active' : '' }}">
                Selesai <span class="adx-filter-count">{{ $statusCounts['completed'] }}</span>
            </button>
            <button wire:click="$set('filterStatus', 'terminated')" class="adx-filter-tab {{ $filterStatus === 'terminated' ? 'active' : '' }}">
                Terminasi <span class="adx-filter-count">{{ $statusCounts['terminated'] }}</span>
            </button>
            <button wire:click="$set('filterStatus', '')" class="adx-filter-tab {{ $filterStatus === '' ? 'active' : '' }}">
                Semua <span class="adx-filter-count">{{ $statusCounts['total'] }}</span>
            </button>
        </div>
    </div>

    @php
        $internships->each(function($internship) {
            $internship->participantName = $internship->intern->internProfile->full_name ?? $internship->intern->email;
        });
    @endphp

    {{-- ═══ TABLE ═══ --}}
    <div class="adx-card adx-table-card">
        <div class="adx-table-scroll">
            <table class="adx-table">
                <thead>
                    <tr>
                        <th>Peserta</th>
                        <th>Lowongan</th>
                        <th>Pembimbing</th>
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
                                    <div class="skeleton-text skeleton-text-sm" style="width:180px"></div>
                                </div>
                            </div>
                        </td>
                        <td><div class="skeleton-text skeleton-text-sm" style="width:150px"></div></td>
                        <td><div class="skeleton" style="width:90px;height:22px;border-radius:20px"></div></td>
                        <td><div class="skeleton" style="width:70px;height:22px;border-radius:20px"></div></td>
                        <td>
                            <div class="adx-actions" style="justify-content:flex-end">
                                <div class="skeleton" style="width:130px;height:34px;border-radius:9px"></div>
                            </div>
                        </td>
                    </tr>
                    @endfor
                </tbody>
                <tbody wire:loading.remove>
                    @forelse($internships as $internship)
                    <tr>
                        <td>
                            <div class="adx-table-user">
                                <x-avatar name="{{ $internship->participantName }}" size="36" type="r" />
                                <div>
                                    <div class="adx-table-name">{{ $internship->participantName }}</div>
                                    <div class="adx-table-email">{{ $internship->intern->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="adx-table-title-cell">{{ $internship->vacancy->title ?? '-' }}</span>
                        </td>
                        <td>
                            @if($internship->supervisor)
                                <span class="adx-supervisor-name">{{ $internship->supervisor->supervisorProfile->full_name ?? $internship->supervisor->email }}</span>
                            @else
                                <span class="adx-chip adx-chip-unassigned"><i class="ti ti-user-off"></i> Belum ditugaskan</span>
                            @endif
                        </td>
                        <td>
                            <span class="adx-chip adx-chip-{{ $internship->status }}">
                                {{ $internship->status === 'active' ? 'Aktif' : ($internship->status === 'completed' ? 'Selesai' : 'Terminasi') }}
                            </span>
                        </td>
                        <td class="text-right">
                            @if($internship->status === 'active')
                            <select x-on:change="if ($event.target.value) $wire.assignSupervisor('{{ $internship->id }}', $event.target.value)"
                                    wire:loading.attr="disabled" wire:loading.class="opacity-60"
                                    class="adx-select adx-select-sm">
                                <option value="">Pilih Pembimbing</option>
                                @foreach($supervisors as $s)
                                    <option value="{{ $s->id }}" @selected($internship->supervisor_id === $s->id)>
                                        {{ $s->supervisorProfile->full_name ?? $s->email }}
                                    </option>
                                @endforeach
                            </select>
                            @else
                            <span class="adx-inline-note">Tidak ada aksi</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <x-empty-state icon="ti-users" message="Belum ada data magang." />
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $internships->links('components.pagination', ['paginator' => $internships]) }}
</div>