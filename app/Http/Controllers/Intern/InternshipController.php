<?php

namespace App\Http\Controllers\Intern;

use App\Http\Controllers\Controller;
use App\Http\Resources\InternshipResource;
use App\Models\Internship;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InternshipController extends Controller
{
    use ApiResponse;

    public function index(): View
    {
        $internship = Internship::with([
            'vacancy', 'supervisor.supervisorProfile',
        ])->where('intern_id', auth()->id())->latest()->first();

        return view('intern.internship.index', compact('internship'));
    }

    public function myInternship(Request $request): JsonResponse
    {
        $internship = Internship::with([
            'vacancy', 'supervisor.supervisorProfile',
        ])->where('intern_id', $request->user()->id)->latest()->first();

        return $this->success(
            $internship ? new InternshipResource($internship) : null,
            'Data magang berhasil dimuat.'
        );
    }
}
