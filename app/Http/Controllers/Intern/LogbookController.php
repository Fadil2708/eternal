<?php

namespace App\Http\Controllers\Intern;

use App\Http\Controllers\Controller;
use App\Http\Requests\Logbook\StoreLogbookRequest;
use App\Http\Resources\LogbookResource;
use App\Models\Logbook;
use App\Notifications\LogbookNotification;
use App\Services\LogbookService;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class LogbookController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly LogbookService $logbookService
    ) {}

    public function store(string $internshipId, StoreLogbookRequest $request): JsonResponse
    {
        try {
            $logbook = $this->logbookService->create(
                $internshipId,
                $request->user(),
                $request->validated()
            );
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 422);
        }

        return $this->success(
            new LogbookResource($logbook),
            'Logbook berhasil dibuat.',
            201
        );
    }

    public function update(string $id, StoreLogbookRequest $request): JsonResponse
    {
        try {
            $logbook = Logbook::where('intern_id', $request->user()->id)->findOrFail($id);

            $this->logbookService->update(
                $logbook,
                $request->validated(),
                $request->user()
            );

            $logbook->refresh();
        } catch (ModelNotFoundException $e) {
            return $this->error('Logbook tidak ditemukan atau bukan milik Anda.', 422);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 422);
        }

        return $this->success(
            new LogbookResource($logbook),
            'Logbook berhasil diperbarui.'
        );
    }

    public function submit(string $id): JsonResponse
    {
        try {
            $logbook = Logbook::where('intern_id', auth()->id())->findOrFail($id);

            $this->logbookService->submit($logbook, auth()->user());

            $logbook->refresh();
        } catch (ModelNotFoundException $e) {
            return $this->error('Logbook tidak ditemukan atau bukan milik Anda.', 422);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 422);
        }

        if ($supervisor = $logbook->internship?->supervisor) {
            $supervisor->notify(new LogbookNotification($logbook, 'new_submission'));
        }

        return $this->success(
            new LogbookResource($logbook),
            'Logbook berhasil dikirim ke supervisor.'
        );
    }
}
