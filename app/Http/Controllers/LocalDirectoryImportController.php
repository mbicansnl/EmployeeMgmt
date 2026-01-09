<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LocalDirectoryImportController
{
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'people' => ['required', 'array'],
            'people.*.email' => ['required', 'email'],
            'people.*.name' => ['required', 'string'],
        ]);

        $count = 0;
        foreach ($request->input('people', []) as $payload) {
            Person::query()->updateOrCreate(
                ['email' => $payload['email']],
                [
                    'name' => $payload['name'],
                    'employee_type' => $payload['employee_type'] ?? 'employee',
                    'status' => $payload['status'] ?? 'active',
                    'source' => 'local',
                ]
            );
            $count++;
        }

        return response()->json(['imported' => $count]);
    }
}
