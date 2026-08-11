<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

abstract class Controller
{
    protected function success(mixed $data, string $message = 'Success', int $code = 200, mixed $meta = null): JsonResponse
    {
        $response = ['success' => true, 'message' => $message, 'data' => $data];
        if ($meta) {
            $response['meta'] = $meta;
        }

        return response()->json($response, $code);
    }

    protected function created(mixed $data, string $message = 'Created'): JsonResponse
    {
        return $this->success($data, $message, 201);
    }

    protected function error(string $message, int $code = 400, mixed $errors = null): JsonResponse
    {
        $response = ['success' => false, 'message' => $message];
        if ($errors) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }

    protected function getAuthUser(): User
    {
        return auth()->user();
    }

    protected function redirectWithMessage(string $route, string $message, string $type = 'success'): RedirectResponse
    {
        return redirect()->route($route)->with($type, $message);
    }

    protected function backWithError(string $message): RedirectResponse
    {
        return back()->with('error', $message);
    }
}
