<div class="adx-root">
    {{-- ═══ HEADER ═══ --}}
    <div class="adx-header">
        <div>
            <div class="breadcrumb">
                <a href="{{ route('admin.dashboard') }}" wire:navigate>Dashboard</a>
                <i class="ti ti-chevron-right"></i>
                <span>Lowongan</span>
            </div>
            <h2 class="adx-title">Kelola Lowongan</h2>
            <p class="adx-sub">Atur lowongan magang yang ditampilkan ke publik</p>
        </div>

        <div class="adx-header-right">
            <a href="{{ route('admin.vacancies.create') }}" wire:navigate class="adx-btn adx-btn-primary">
                <i class="ti ti-plus"></i> Lowongan Baru
            </a>
        </div>
    </div>

    {{-- ═══ TOOLBAR ═══ --}}
    <div class="adx-toolbar">
        <div class="adx-search">
            <i class="ti ti-search"></i>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari judul atau divisi...">
        </div>

        <div class="adx-filter-tabs" role="tablist" aria-label="Filter status">
            <button wire:click="$set('filterStatus', '')" class="adx-filter-tab {{ $filterStatus === '' ? 'active' : '' }}">
                Semua <span class="adx-filter-count">{{ $statusCounts['total'] }}</span>
            </button>
            <button wire:click="$set('filterStatus', 'open')" class="adx-filter-tab {{ $filterStatus === 'open' ? 'active' : '' }}">
                Open <span class="adx-filter-count">{{ $statusCounts['open'] }}</span>
            </button>
            <button wire:click="$set('filterStatus', 'draft')" class="adx-filter-tab {{ $filterStatus === 'draft' ? 'active' : '' }}">
                Draft <span class="adx-filter-count">{{ $statusCounts['draft'] }}</span>
            </button>
            <button wire:click="$set('filterStatus', 'closed')" class="adx-filter-tab {{ $filterStatus === 'closed' ? 'active' : '' }}">
                Closed <span class="adx-filter-count">{{ $statusCounts['closed'] }}</span>
            </button>
        </div>
    </div>

    {{-- ═══ TABLE ═══ --}}
    <div class="adx-card adx-table-card">
        <div class="adx-table-scroll">
            <table class="adx-table">
                <thead>
                    <tr>
                        <th wire:click="sortBy('title')" class="cursor-pointer">
                            Judul
                            @if($sortField === 'title')
                                <span class="adx-sort-arrow">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </th>
                        <th>Divisi</th>
                        <th>Kuota</th>
                        <th>Batas Daftar</th>
                        <th>Status</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody wire:loading>
                    @for($i = 0; $i < 5; $i++)
                    <tr>
                        <td><div class="skeleton-text skeleton-text-lg" style="width:180px"></div></td>
                        <td><div class="skeleton-text skeleton-text-sm" style="width:90px"></div></td>
                        <td><div class="skeleton" style="width:110px;height:18px;border-radius:6px"></div></td>
                        <td><div class="skeleton-text skeleton-text-sm" style="width:90px"></div></td>
                        <td><div class="skeleton" style="width:70px;height:22px;border-radius:20px"></div></td>
                        <td>
                            <div class="adx-actions">
                                <div class="skeleton" style="width:32px;height:32px;border-radius:9px"></div>
                                <div class="skeleton" style="width:32px;height:32px;border-radius:9px"></div>
                            </div>
                        </td>
                    </tr>
                    @endfor
                </tbody>
                <tbody wire:loading.remove>
                    @forelse($vacancies as $v)
                    @php
                        $accepted = $v->accepted_applications_count ?? 0;
                        $isFull = $accepted >= $v->quota;
                        $pct = $v->quota > 0 ? min(100, round($accepted / $v->quota * 100)) : 0;
                    @endphp
                    <tr>
                        <td>
                            <div class="adx-table-title">
                                <div class="adx-vacancy-icon">
                                    <i class="ti ti-building-skyscraper"></i>
                                </div>
                                <div>
                                    <div class="adx-table-name">{{ $v->title }}</div>
                                    <div class="adx-table-email">{{ $v->creator?->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="adx-division">{{ $v->division ?? '-' }}</span></td>
                        <td>
                            <div class="adx-quota">
                                <div class="adx-quota-head">
                                    <span>{{ $accepted }} / {{ $v->quota }}</span>
                                    @if($isFull)
                                        <span class="adx-quota-full"><i class="ti ti-circle-check"></i> Penuh</span>
                                    @endif
                                </div>
                                <div class="adx-quota-track">
                                    <div class="adx-quota-bar {{ $isFull ? 'is-full' : '' }}" style="width:{{ $pct }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td><span class="adx-date">{{ $v->application_deadline->format('d M Y') }}</span></td>
                        <td>
                            <span class="adx-chip adx-chip-{{ $v->status }}">
                                {{ $v->status === 'open' ? 'Open' : ($v->status === 'draft' ? 'Draft' : 'Closed') }}
                            </span>
                        </td>
                        <td class="text-right">
                            <div class="adx-actions">
                                <a href="{{ route('admin.vacancies.edit', $v->id) }}" wire:navigate class="adx-action" title="Edit">
                                    <i class="ti ti-pencil"></i>
                                </a>
                                <button wire:loading.attr="disabled" wire:loading.class="opacity-60 cursor-wait"
                                        @click="window.dispatchEvent(new CustomEvent('confirm', { detail: { message: 'Hapus lowongan ini?', callback: () => $wire.deleteVacancy('{{ $v->id }}') } }))"
                                        class="adx-action is-danger" title="Hapus">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <x-empty-state icon="ti-building" message="Belum ada lowongan." />
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $vacancies->links('components.pagination', ['paginator' => $vacancies]) }}
</div>