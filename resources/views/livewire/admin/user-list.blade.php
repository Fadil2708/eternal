<div class="adx-root">
    {{-- ═══ HEADER ═══ --}}
    <div class="adx-header">
        <div>
            <div class="breadcrumb">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <i class="ti ti-chevron-right"></i>
                <span>Pengguna</span>
            </div>
            <h2 class="adx-title">Kelola Pengguna</h2>
            <p class="adx-sub">Atur pengguna, pembimbing, dan admin sistem</p>
        </div>

        <div class="adx-header-right">
            <a href="{{ route('admin.users.create') }}" wire:navigate class="adx-btn adx-btn-primary">
                <i class="ti ti-user-plus"></i> Tambah Pengguna
            </a>
        </div>
    </div>

    {{-- ═══ TOOLBAR ═══ --}}
    <div class="adx-toolbar">
        <div class="adx-search">
            <i class="ti ti-search"></i>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama atau email...">
        </div>

        <div class="adx-filter-tabs" role="tablist" aria-label="Filter role">
            <button wire:click="$set('filterRole', '')" class="adx-filter-tab {{ $filterRole === '' ? 'active' : '' }}">
                Semua <span class="adx-filter-count">{{ $roleCounts['total'] }}</span>
            </button>
            <button wire:click="$set('filterRole', 'admin')" class="adx-filter-tab {{ $filterRole === 'admin' ? 'active' : '' }}">
                Admin <span class="adx-filter-count">{{ $roleCounts['admin'] }}</span>
            </button>
            <button wire:click="$set('filterRole', 'supervisor')" class="adx-filter-tab {{ $filterRole === 'supervisor' ? 'active' : '' }}">
                Pembimbing <span class="adx-filter-count">{{ $roleCounts['supervisor'] }}</span>
            </button>
            <button wire:click="$set('filterRole', 'intern')" class="adx-filter-tab {{ $filterRole === 'intern' ? 'active' : '' }}">
                Peserta <span class="adx-filter-count">{{ $roleCounts['intern'] }}</span>
            </button>
        </div>
    </div>

    {{-- ═══ TABLE ═══ --}}
    <div class="adx-card adx-table-card">
        <div class="adx-table-scroll">
            <table class="adx-table">
                <thead>
                    <tr>
                        <th>Pengguna</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Tgl Daftar</th>
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
                        <td><div class="skeleton" style="width:80px;height:22px;border-radius:20px"></div></td>
                        <td><div class="skeleton" style="width:60px;height:22px;border-radius:20px"></div></td>
                        <td><div class="skeleton-text skeleton-text-sm" style="width:70px;margin-bottom:0"></div></td>
                        <td>
                            <div class="adx-actions" style="justify-content:flex-end">
                                <div class="skeleton" style="width:32px;height:32px;border-radius:9px"></div>
                                <div class="skeleton" style="width:32px;height:32px;border-radius:9px"></div>
                            </div>
                        </td>
                    </tr>
                    @endfor
                </tbody>
                <tbody wire:loading.remove>
                    @forelse($users as $user)
                    @php
                        $displayName = $user->internProfile?->full_name ?? $user->supervisorProfile?->full_name ?? $user->email;
                    @endphp
                    <tr>
                        <td>
                            <div class="adx-table-user">
                                <x-avatar name="{{ $displayName }}" size="36" type="r" />
                                <div>
                                    <div class="adx-table-name">{{ $displayName }}</div>
                                    <div class="adx-table-email">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="adx-chip adx-chip-{{ $user->role }}">
                                {{ $user->role === 'admin' ? 'Admin' : ($user->role === 'supervisor' ? 'Pembimbing' : 'Peserta') }}
                            </span>
                        </td>
                        <td>
                            <span class="adx-status {{ $user->is_active ? 'is-active' : 'is-inactive' }}">
                                <span class="adx-status-dot"></span>
                                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <span class="adx-date">{{ $user->created_at->format('d M Y') }}</span>
                        </td>
                        <td class="text-right">
                            <div class="adx-actions">
                                <a href="{{ route('admin.users.edit', $user->id) }}" wire:navigate class="adx-action" title="Edit">
                                    <i class="ti ti-pencil"></i>
                                </a>
                                <button wire:click="confirmDeactivate('{{ $user->id }}')"
                                        wire:loading.attr="disabled" wire:loading.class="opacity-60 cursor-wait"
                                        class="adx-action {{ $user->is_active ? 'is-danger' : 'is-success' }}"
                                        title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                    <i class="ti ti-{{ $user->is_active ? 'user-x' : 'user-check' }}"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <x-empty-state icon="ti-users" message="Belum ada pengguna." />
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $users->links('components.pagination', ['paginator' => $users]) }}

    @if($confirmingDeactivateId)
    <div class="modal-wrap" aria-labelledby="modal-title" role="dialog" aria-modal="true"
         x-data
         @keydown.escape.window="$wire.set('confirmingDeactivateId', null)">
        <div class="modal-backdrop" @click="$wire.set('confirmingDeactivateId', null)"></div>
        <div class="modal-center">
            <div class="modal-card modal-card-md">
                <div class="modal-header">
                    <h3 id="modal-title" class="modal-title">Konfirmasi</h3>
                </div>
                <div class="modal-body">
                    <div class="adx-modal-icon"><i class="ti ti-alert-triangle"></i></div>
                    <p class="adx-modal-text">Yakin ingin mengubah status akun pengguna ini?</p>
                </div>
                <div class="modal-footer">
                    <button wire:click="$set('confirmingDeactivateId', null)" class="btn-secondary">Batal</button>
                    <button wire:click="deactivate"
                            wire:loading.attr="disabled" wire:loading.class="opacity-60 cursor-wait"
                            class="adx-btn adx-btn-primary">
                        <span wire:loading.remove>Ya, Lanjutkan</span>
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