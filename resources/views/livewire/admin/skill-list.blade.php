<div>
    <div class="page-header">
        <div>
            <div class="breadcrumb">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <i class="ti ti-chevron-right"></i>
                <span>Keahlian</span>
            </div>
            <h2 class="page-title">Keahlian (Skill)</h2>
            <p class="page-sub">Kelola daftar keahlian yang bisa dipilih peserta magang di profil</p>
        </div>
        <button wire:click="create" class="btn-primary">
            <i class="ti ti-plus"></i> Tambah Keahlian
        </button>
    </div>

    @if($editingId)
    <div class="panel form-card" style="margin-bottom:16px">
        <h3 class="text-h3" style="margin-bottom:16px">{{ $editingId === 'new' ? 'Tambah' : 'Edit' }} Keahlian</h3>
        <form wire:submit="save">
            <div class="form-row">
                <div class="field">
                    <label>Nama Keahlian <span class="required">*</span></label>
                    <input wire:model="name" type="text" class="input" placeholder="Contoh: Laravel">
                    @error('name') <div class="field-error">{{ $message }}</div> @enderror
                </div>
                <div class="field">
                    <label>Kategori</label>
                    <input wire:model="category" type="text" class="input" placeholder="Contoh: Programming">
                    @error('category') <div class="field-error">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="btn-bar" style="margin-top:16px">
                <button type="button" wire:click="cancel" class="btn-outline">
                    <i class="ti ti-x"></i> Batal
                </button>
                <button type="submit" wire:loading.attr="disabled" class="btn-save">
                    <i wire:loading.remove class="ti ti-device-floppy"></i>
                    <span wire:loading.remove>Simpan</span>
                    <span wire:loading class="inline-flex items-center gap-1">
                        <i class="ti ti-loader animate-spin"></i> Menyimpan...
                    </span>
                </button>
            </div>
        </form>
    </div>
    @endif

    <div class="filter-bar">
        <div class="search-box">
            <i class="ti ti-search"></i>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama atau kategori keahlian...">
        </div>
    </div>

    <div class="panel overflow-x-auto">
        <table class="data">
            <thead>
                <tr>
                    <th style="width:40px">No</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th style="width:120px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($skills as $skill)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <span style="font-weight:600;color:#1E1C1A;font-size:13px">{{ $skill->name }}</span>
                    </td>
                    <td>
                        @if($skill->category)
                        <span class="badge accepted">{{ $skill->category }}</span>
                        @else
                        <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-btns">
                            <button wire:click="edit('{{ $skill->id }}')" class="action-btn" title="Edit">
                                <i class="ti ti-pencil"></i>
                            </button>
                            <button wire:click="delete('{{ $skill->id }}')"
                                    wire:loading.attr="disabled"
                                    class="action-btn danger"
                                    title="Hapus">
                                <i class="ti ti-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">
                        <x-empty-state icon="ti-tool" message="Belum ada keahlian." />
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrap">
        {{ $skills->links() }}
    </div>
</div>