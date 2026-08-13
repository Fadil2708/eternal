<?php

namespace App\Http\Controllers\Intern;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateInternProfileRequest;
use App\Http\Resources\InternProfileResource;
use App\Services\FileUploadService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly FileUploadService $fileUploadService
    ) {}

    public function update(UpdateInternProfileRequest $request): JsonResponse
    {
        $user = $request->user();
        $data = $request->validated();
        $profile = $user->internProfile;

        unset($data['photo_url'], $data['cv_url'], $data['cover_letter_url']);

        $toDelete = [];

        if ($request->hasFile('photo_url')) {
            $url = $this->fileUploadService->uploadProfilePhoto(
                $request->file('photo_url'), $user->id
            );
            if (! $url) {
                return $this->error('Gagal mengupload foto profil.', 500);
            }
            $data['photo_url'] = $url;
            if ($profile?->photo_url) {
                $toDelete[] = $profile->photo_url;
            }
        }

        if ($request->hasFile('cv_url')) {
            $url = $this->fileUploadService->uploadCv(
                $request->file('cv_url'), $user->id
            );
            if (! $url) {
                return $this->error('Gagal mengupload CV.', 500);
            }
            $data['cv_url'] = $url;
            if ($profile?->cv_url) {
                $toDelete[] = $profile->cv_url;
            }
        }

        if ($request->hasFile('cover_letter_url')) {
            $url = $this->fileUploadService->uploadCoverLetter(
                $request->file('cover_letter_url'), $user->id
            );
            if (! $url) {
                return $this->error('Gagal mengupload cover letter.', 500);
            }
            $data['cover_letter_url'] = $url;
            if ($profile?->cover_letter_url) {
                $toDelete[] = $profile->cover_letter_url;
            }
        }

        $profile = $user->internProfile()->updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        foreach ($toDelete as $oldFile) {
            $this->fileUploadService->delete($oldFile);
        }

        return $this->success(
            new InternProfileResource($profile),
            'Profil berhasil diperbarui.'
        );
    }
}
