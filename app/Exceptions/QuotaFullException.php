<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class QuotaFullException extends Exception
{
    public function __construct()
    {
        parent::__construct('Kuota lowongan sudah penuh.', 422);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
        ], 422);
    }
}
