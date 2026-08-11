<?php

namespace App\Livewire\Intern;

use App\Models\InternProfile;
use App\Models\Skill;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ProfileForm extends Component
{
    use WithFileUploads;

    public $full_name = '';
    public $gender = '';
    public $phone = '';
    public $address = '';
    public $date_of_birth = '';
    public $institution_name = '';
    public $institution_type = '';
    public $major = '';
    public $student_id = '';

    public ?TemporaryUploadedFile $photo = null;
    public ?TemporaryUploadedFile $cv = null;
    public ?TemporaryUploadedFile $cover_letter = null;

    public $selectedSkills = [];

    public $existingPhoto = null;
    public $existingCv = null;
    public $existingCoverLetter = null;

    public $allSkills = [];
    public $skillsList = [];

    public bool $isEditing = false;
    public bool $hasProfile = false;

    public function mount(): void
    {
        $profile = InternProfile::where('user_id', auth()->id())->first();

        $this->allSkills = Skill::orderBy('name')->get();
        $this->hasProfile = $profile !== null;

        if ($profile) {
            $this->full_name = $profile->full_name ?? '';
            $this->gender = $profile->gender ?? '';
            $this->phone = $profile->phone ?? '';
            $this->address = $profile->address ?? '';
            $this->date_of_birth = $profile->date_of_birth?->format('Y-m-d') ?? '';
            $this->institution_name = $profile->institution_name ?? '';
            $this->institution_type = $profile->institution_type ?? '';
            $this->major = $profile->major ?? '';
            $this->student_id = $profile->student_id ?? '';

            $this->existingPhoto = $profile->photo_url;
            $this->existingCv = $profile->cv_url;
            $this->existingCoverLetter = $profile->cover_letter_url;

            $this->selectedSkills = $profile->skills
                ->pluck('id')
                ->map(fn ($id) => (string) $id)
                ->toArray();

            $this->skillsList = $profile->skills;
        }
    }

    /**
     * Dipanggil Livewire ketika foto selesai di-upload
     */
    public function updatedPhoto(): void
    {
        Log::info('PHOTO UPLOAD RECEIVED', [
            'exists' => $this->photo !== null,
            'class' => $this->photo ? get_class($this->photo) : null,
            'name' => $this->photo?->getClientOriginalName(),
            'mime' => $this->photo?->getMimeType(),
            'size' => $this->photo?->getSize(),
        ]);
    }

    public function updatedCv(): void
    {
        Log::info('CV UPLOAD RECEIVED', [
            'exists' => $this->cv !== null,
            'name' => $this->cv?->getClientOriginalName(),
            'mime' => $this->cv?->getMimeType(),
            'size' => $this->cv?->getSize(),
        ]);
    }

    public function updatedCoverLetter(): void
    {
        Log::info('COVER LETTER UPLOAD RECEIVED', [
            'exists' => $this->cover_letter !== null,
            'name' => $this->cover_letter?->getClientOriginalName(),
            'mime' => $this->cover_letter?->getMimeType(),
            'size' => $this->cover_letter?->getSize(),
        ]);
    }

    public function save(): void
    {
        Log::info('PROFILE SAVE DEBUG', [
            'user_id' => auth()->id(),

            'photo_exists' => $this->photo !== null,
            'photo_class' => $this->photo ? get_class($this->photo) : null,
            'photo_original_name' => $this->photo?->getClientOriginalName(),
            'photo_mime' => $this->photo?->getMimeType(),
            'photo_size' => $this->photo?->getSize(),

            'cv_exists' => $this->cv !== null,
            'cover_letter_exists' => $this->cover_letter !== null,
        ]);

        $this->validate([
            'full_name' => 'required|string|max:255',
            'gender' => 'nullable|in:male,female',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'institution_name' => 'required|string|max:255',
            'institution_type' => 'nullable|string|max:255',
            'major' => 'nullable|string|max:255',
            'student_id' => 'nullable|string|max:50',

            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'cv' => 'nullable|file|mimes:pdf|max:5120',
            'cover_letter' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $data = [
            'user_id' => auth()->id(),
            'full_name' => $this->full_name,
            'gender' => $this->gender,
            'phone' => $this->phone,
            'address' => $this->address,
            'date_of_birth' => $this->date_of_birth ?: null,
            'institution_name' => $this->institution_name,
            'institution_type' => $this->institution_type,
            'major' => $this->major,
            'student_id' => $this->student_id,
        ];

        /*
        |--------------------------------------------------------------------------
        | FOTO
        |--------------------------------------------------------------------------
        */

        if ($this->photo instanceof TemporaryUploadedFile) {

            Log::info('PHOTO IS VALID TEMPORARY FILE');

            $photoPath = $this->photo->store('photos', 'public');

            Log::info('PHOTO STORED', [
                'path' => $photoPath,
                'exists' => Storage::disk('public')->exists($photoPath),
                'full_path' => Storage::disk('public')->path($photoPath),
            ]);

            $data['photo_url'] = $photoPath;
        } else {
            Log::warning('PHOTO IS EMPTY');
        }

        /*
        |--------------------------------------------------------------------------
        | CV
        |--------------------------------------------------------------------------
        */

        if ($this->cv instanceof TemporaryUploadedFile) {

            $cvPath = $this->cv->store('cvs', 'public');

            Log::info('CV STORED', [
                'path' => $cvPath,
            ]);

            $data['cv_url'] = $cvPath;
        }

        /*
        |--------------------------------------------------------------------------
        | COVER LETTER
        |--------------------------------------------------------------------------
        */

        if ($this->cover_letter instanceof TemporaryUploadedFile) {

            $coverLetterPath = $this->cover_letter->store(
                'cover-letters',
                'public'
            );

            Log::info('COVER LETTER STORED', [
                'path' => $coverLetterPath,
            ]);

            $data['cover_letter_url'] = $coverLetterPath;
        }

        /*
        |--------------------------------------------------------------------------
        | SAVE PROFILE
        |--------------------------------------------------------------------------
        */

        $profile = InternProfile::updateOrCreate(
            ['user_id' => auth()->id()],
            $data
        );

        /*
        |--------------------------------------------------------------------------
        | SKILLS
        |--------------------------------------------------------------------------
        */

        $profile->skills()->sync($this->selectedSkills);

        /*
        |--------------------------------------------------------------------------
        | REFRESH STATE
        |--------------------------------------------------------------------------
        */

        $this->existingPhoto = $profile->photo_url;
        $this->existingCv = $profile->cv_url;
        $this->existingCoverLetter = $profile->cover_letter_url;

        $this->skillsList = $profile->skills;
        $this->hasProfile = true;

        $this->photo = null;
        $this->cv = null;
        $this->cover_letter = null;

        $this->isEditing = false;

        Log::info('PROFILE SAVED SUCCESSFULLY', [
            'profile_id' => $profile->id,
            'photo_url' => $profile->photo_url,
            'cv_url' => $profile->cv_url,
            'cover_letter_url' => $profile->cover_letter_url,
        ]);

        $this->dispatch(
            'toast',
            message: 'Profil berhasil disimpan.',
            type: 'success'
        );
    }

    public function cancelEdit(): void
    {
        $profile = InternProfile::where('user_id', auth()->id())->first();

        if (!$profile) {
            $this->isEditing = false;
            return;
        }

        $this->full_name = $profile->full_name ?? '';
        $this->gender = $profile->gender ?? '';
        $this->phone = $profile->phone ?? '';
        $this->address = $profile->address ?? '';
        $this->date_of_birth = $profile->date_of_birth?->format('Y-m-d') ?? '';
        $this->institution_name = $profile->institution_name ?? '';
        $this->institution_type = $profile->institution_type ?? '';
        $this->major = $profile->major ?? '';
        $this->student_id = $profile->student_id ?? '';

        $this->existingPhoto = $profile->photo_url;
        $this->existingCv = $profile->cv_url;
        $this->existingCoverLetter = $profile->cover_letter_url;

        $this->selectedSkills = $profile->skills
            ->pluck('id')
            ->map(fn ($id) => (string) $id)
            ->toArray();

        $this->skillsList = $profile->skills;

        $this->photo = null;
        $this->cv = null;
        $this->cover_letter = null;

        $this->resetValidation();

        $this->isEditing = false;
    }

    public function render()
    {
        return view('livewire.intern.profile-form');
    }
}