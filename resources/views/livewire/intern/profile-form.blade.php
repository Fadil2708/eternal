<div>
    <div class="page-header">
        <div>
            <div class="breadcrumb">
                <span>Profil</span>
            </div>
            <h2 class="page-title">{{ $isEditing ? 'Edit Profil' : 'Profil Saya' }}</h2>
            <p class="page-sub">{{ $isEditing ? 'Ubah data diri dan dokumen Anda' : 'Data diri Anda sebagai peserta magang' }}</p>
        </div>
        @if($hasProfile)
            <div style="display:flex;align-items:center;gap:8px">
                <span class="badge-success">
                    <i class="ti ti-circle-check"></i> Profil Lengkap
                </span>
                @if(!$isEditing)
                    <button type="button" wire:click="$set('isEditing', true)" class="btn-primary">
                        <i class="ti ti-pencil"></i> Edit Profil
                    </button>
                @endif
            </div>
        @endif
    </div>

    <div class="form-layout">
        <div class="panel" style="padding:24px">

            @if(!$isEditing && $hasProfile)
                {{-- ═══ MODE LIHAT ═══ --}}
                <div class="profile-display">
                    <div style="display:flex;align-items:center;gap:14px;margin-bottom:18px">
                        <div class="profile-avatar">
                            @if($existingPhoto)
                                <img src="{{ route('profile.file', 'photo') }}" alt="Foto Profil" loading="lazy" width="64" height="64">
                            @else
                                {{ strtoupper(substr($full_name, 0, 1)) }}
                            @endif
                        </div>
                        <div>
                            <div style="font-size:15px;font-weight:700;color:#1E1C1A">{{ $full_name }}</div>
                            <div style="font-size:12px;color:#5C5A55;margin-top:1px">{{ $institution_name }}</div>
                        </div>
                    </div>

                    <div class="form-section-title">Data Pribadi</div>
                    <div class="profile-grid">
                        <div class="profile-item">
                            <div class="profile-label"><i class="ti ti-user"></i> Nama Lengkap</div>
                            <div class="profile-value">@if($full_name){{ $full_name }}@else<span class="empty">—</span>@endif</div>
                        </div>
                        <div class="profile-item">
                            <div class="profile-label"><i class="ti ti-gender-male"></i> Jenis Kelamin</div>
                            <div class="profile-value">
                                @if($gender === 'male') Laki-laki
                                @elseif($gender === 'female') Perempuan
                                @else <span class="empty">—</span>
                                @endif
                            </div>
                        </div>
                        <div class="profile-item">
                            <div class="profile-label"><i class="ti ti-id"></i> NIM / NIS</div>
                            <div class="profile-value">@if($student_id){{ $student_id }}@else<span class="empty">—</span>@endif</div>
                        </div>
                        <div class="profile-item">
                            <div class="profile-label"><i class="ti ti-building"></i> Nama Institusi</div>
                            <div class="profile-value">@if($institution_name){{ $institution_name }}@else<span class="empty">—</span>@endif</div>
                        </div>
                        <div class="profile-item">
                            <div class="profile-label"><i class="ti ti-category"></i> Jenis Institusi</div>
                            <div class="profile-value">
                                @switch($institution_type)
                                    @case('university') Universitas @break
                                    @case('vocational') SMK / Politeknik @break
                                    @case('highschool') SMA / Sederajat @break
                                    @default <span class="empty">—</span>
                                @endswitch
                            </div>
                        </div>
                        <div class="profile-item">
                            <div class="profile-label"><i class="ti ti-book"></i> Jurusan</div>
                            <div class="profile-value">@if($major){{ $major }}@else<span class="empty">—</span>@endif</div>
                        </div>
                        <div class="profile-item">
                            <div class="profile-label"><i class="ti ti-phone"></i> No. Telepon</div>
                            <div class="profile-value">@if($phone){{ $phone }}@else<span class="empty">—</span>@endif</div>
                        </div>
                        <div class="profile-item">
                            <div class="profile-label"><i class="ti ti-cake"></i> Tanggal Lahir</div>
                            <div class="profile-value">@if($date_of_birth){{ \Carbon\Carbon::parse($date_of_birth)->translatedFormat('d F Y') }}@else<span class="empty">—</span>@endif</div>
                        </div>
                        <div class="profile-item" style="grid-column: span 2">
                            <div class="profile-label"><i class="ti ti-map-pin"></i> Alamat</div>
                            <div class="profile-value">@if($address){{ $address }}@else<span class="empty">—</span>@endif</div>
                        </div>
                        <div class="profile-item" style="grid-column: span 2">
                            <div class="profile-label"><i class="ti ti-star"></i> Keahlian</div>
                            <div class="profile-value">
                                @forelse($skillsList as $skill)
                                    <span class="skill-badge">{{ $skill->name }}</span>
                                @empty
                                    <span class="empty">—</span>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="form-section-title" style="margin-top:24px">Dokumen</div>
                    <div class="profile-docs">
                        @if($existingPhoto)
                            <a href="{{ route('profile.file', 'photo') }}" target="_blank" class="profile-doc done">
                                <i class="ti ti-circle-check"></i>
                                <span>Foto Profil</span>
                            </a>
                        @else
                            <span class="profile-doc">
                                <i class="ti ti-circle-x"></i>
                                <span>Foto Profil</span>
                            </span>
                        @endif
                        @if($existingCv)
                            <a href="{{ route('profile.file', 'cv') }}" target="_blank" class="profile-doc done">
                                <i class="ti ti-circle-check"></i>
                                <span>CV / Resume</span>
                            </a>
                        @else
                            <span class="profile-doc">
                                <i class="ti ti-circle-x"></i>
                                <span>CV / Resume</span>
                            </span>
                        @endif
                        @if($existingCoverLetter)
                            <a href="{{ route('profile.file', 'cover-letter') }}" target="_blank" class="profile-doc done">
                                <i class="ti ti-circle-check"></i>
                                <span>Surat Permohonan</span>
                            </a>
                        @else
                            <span class="profile-doc">
                                <i class="ti ti-circle-x"></i>
                                <span>Surat Permohonan</span>
                            </span>
                        @endif
                    </div>
                </div>

            @else
                {{-- ═══ MODE EDIT ═══ --}}
                <form wire:submit="save" class="space-y-6" enctype="multipart/form-data">
                    <div class="form-section-title">Data Pribadi</div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="field">
                            <label>Nama Lengkap <span class="required">*</span></label>
                            <input wire:model="full_name" type="text" class="input">
                            @error('full_name') <div class="field-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="field">
                            <label>Jenis Kelamin</label>
                            <select wire:model="gender" class="input">
                                <option value="">Pilih...</option>
                                <option value="male">Laki-laki</option>
                                <option value="female">Perempuan</option>
                            </select>
                            @error('gender') <div class="field-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="field">
                            <label>NIM / NIS <span class="required">*</span></label>
                            <input wire:model="student_id" type="text" class="input">
                            @error('student_id') <div class="field-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="field">
                            <label>Nama Institusi <span class="required">*</span></label>
                            <input wire:model="institution_name" type="text" class="input">
                            @error('institution_name') <div class="field-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="field">
                            <label>Jenis Institusi <span class="required">*</span></label>
                            <select wire:model="institution_type" class="input">
                                <option value="">Pilih...</option>
                                <option value="university">Universitas</option>
                                <option value="vocational">SMK / Politeknik</option>
                                <option value="highschool">SMA / Sederajat</option>
                            </select>
                            @error('institution_type') <div class="field-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="field">
                            <label>Jurusan <span class="required">*</span></label>
                            <input wire:model="major" type="text" class="input" placeholder="Teknik Informatika">
                            @error('major') <div class="field-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="field">
                            <label>No. Telepon</label>
                            <input wire:model="phone" type="text" class="input" placeholder="08xxxxxxxxxx">
                            @error('phone') <div class="field-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="field">
                            <label>Tanggal Lahir</label>
                            <input wire:model="date_of_birth" type="date" class="input">
                            @error('date_of_birth') <div class="field-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="field md:col-span-2">
                            <label>Alamat</label>
                            <textarea wire:model="address" rows="3" class="input"></textarea>
                            @error('address') <div class="field-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="field md:col-span-2">
                            <label>Keahlian</label>
                            <div x-data="skillPicker()" x-init="init(@js($selectedSkills), @js($allSkills->flatten()->map(fn($s) => ['id' => (int)$s->id, 'name' => $s->name])->values()->toArray()))" class="skill-picker-wrap">
                                <div class="skill-trigger" @click="open = !open" @click.away="open = false">
                                    <template x-for="id in selected" :key="id">
                                        <span class="skill-tag" @click.stop="removeSkill(id)">
                                            <span x-text="getName(id)"></span>
                                            <i class="ti ti-x"></i>
                                        </span>
                                    </template>
                                    <span x-show="!selected.length" class="skill-placeholder">Pilih keahlian Anda...</span>
                                </div>
                                <div x-show="open" class="skill-dropdown" x-cloak>
                                    <input type="text" x-model="search" placeholder="Cari keahlian..." class="skill-search-input" @click.stop>
                                    <div x-show="!search.length" class="skill-options">
                                        <div class="skill-category-title">Keahlian Populer</div>
                                        <template x-for="s in allSkills.slice(0, 5)" :key="s.id">
                                            <label class="skill-option">
                                                <input type="checkbox" :value="s.id" x-model="selected" @change="sync($event)">
                                                <span x-text="s.name"></span>
                                                <span class="skill-popular-badge">Populer</span>
                                                <i class="ti ti-check skill-check" x-show="selected.includes(String(s.id))"></i>
                                            </label>
                                        </template>
                                    </div>
                                    <div x-show="search.length > 0" class="skill-options">
                                        <div class="skill-category-title">Semua Keahlian</div>
                                        @foreach($allSkills->flatten() as $skill)
                                        <label class="skill-option" x-show="'{{ strtolower($skill->name) }}'.includes(search.toLowerCase())">
                                            <input type="checkbox" :value="{{ $skill->id }}" x-model="selected" @change="sync($event)">
                                            <span>{{ $skill->name }}</span>
                                            <i class="ti ti-check skill-check" x-show="selected.includes('{{ $skill->id }}')"></i>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <p class="skill-hint">Klik kolom untuk membuka daftar keahlian, pilih sesuai bidang Anda</p>
                            @error('selectedSkills') <div class="field-error">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="form-section-title">Upload Dokumen</div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="field">
                            <label>Foto Profil</label>
                            <input
                                wire:model="photo"
                                type="file"
                                accept="image/jpeg,image/png"
                                class="input"
                            >
                            <div wire:loading wire:target="photo" style="font-size:11px;color:#2563EB;margin-top:5px">
                                <i class="ti ti-loader"></i> Mengupload foto...
                            </div>

                            @if($photo)
                                <div style="font-size:11px;color:#16A34A;margin-top:5px">
                                    <i class="ti ti-circle-check"></i>
                                    {{ $photo->getClientOriginalName() }}
                                </div>
                            @endif

                            @error('photo')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                            @error('photo') <div class="field-error">{{ $message }}</div> @enderror
                            @if($existingPhoto)
                                <div style="font-size:11px;color:#16A34A;margin-top:4px">
                                    <i class="ti ti-circle-check"></i> Foto terunggah
                                </div>
                            @endif
                        </div>
                        <div class="field">
                            <label>CV / Resume</label>
                            <input
                                wire:key="profile-cv-upload"
                                wire:model="cv"
                                type="file"
                                accept=".pdf"
                                class="input"
                            >
                            @error('cv') <div class="field-error">{{ $message }}</div> @enderror
                            @if($existingCv)
                                <div style="font-size:11px;color:#16A34A;margin-top:4px">
                                    <i class="ti ti-circle-check"></i> CV terunggah
                                </div>
                            @endif
                        </div>
                        <div class="field md:col-span-2">
                            <label>Surat Permohonan</label>
                            <input
                                wire:key="profile-cover-letter-upload"
                                wire:model="cover_letter"
                                type="file"
                                accept=".pdf"
                                class="input"
                            >
                            @error('cover_letter') <div class="field-error">{{ $message }}</div> @enderror
                            @if($existingCoverLetter)
                                <div style="font-size:11px;color:#16A34A;margin-top:4px">
                                    <i class="ti ti-circle-check"></i> Surat Permohonan terunggah
                                </div>
                            @endif
                        </div>
                    </div>

                    <div style="display:flex;justify-content:flex-end;gap:8px;padding-top:12px;border-top:1px solid #E8E6E1">
                        @if($hasProfile)
                            <button type="button" wire:click="cancelEdit" class="btn-outline">
                                <i class="ti ti-x"></i> Batal
                            </button>
                        @endif
                        <button type="submit" class="btn-save"
                                wire:loading.attr="disabled"
                                wire:loading.class="opacity-60 cursor-wait">
                            <span wire:loading.remove><i class="ti ti-device-floppy"></i> Simpan Profil</span>
                            <span wire:loading><i class="ti ti-loader" style="animation:spin 1s linear infinite;font-size:16px"></i> Menyimpan...</span>
                        </button>
                    </div>
                </form>
            @endif

        </div>
    </div>
</div>
