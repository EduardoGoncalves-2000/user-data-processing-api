<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserImportService
{
    public function importFromJsonString(string $json): array
    {
        $decoded = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return [
                'ok' => false,
                'status' => 400,
                'error' => 'JSON inválido: ' . json_last_error_msg(),
            ];
        }

        if (!is_array($decoded)) {
            return [
                'ok' => false,
                'status' => 400,
                'error' => 'Formato inválido. Esperado um array de usuários.',
            ];
        }

        if (count($decoded) === 0) {
            return [
                'ok' => false,
                'status' => 422,
                'error' => 'O arquivo não contém usuários.',
            ];
        }

        $batchSize = 1000;
        $totalInFile = count($decoded);
        $processedValid = 0;
        $skippedInvalid = 0;
        $now = now();

        DB::transaction(function () use (
            $decoded,
            $batchSize,
            &$processedValid,
            &$skippedInvalid,
            $now
        ) {
            foreach (array_chunk($decoded, $batchSize) as $chunk) {
                $rows = [];

                foreach ($chunk as $user) {
                    if (!is_array($user)) {
                        $skippedInvalid++;
                        continue;
                    }

                    $normalizedUser = [
                        'id' => $user['_id'] ?? null,
                        'first_name' => $user['first_name'] ?? null,
                        'last_name' => $user['last_name'] ?? null,
                        'email' => $user['email'] ?? null,
                    ];

                    $validator = Validator::make($normalizedUser, [
                        'id' => ['required', 'string'],
                        'first_name' => ['required', 'string'],
                        'last_name' => ['required', 'string'],
                        'email' => ['required', 'email'],
                    ]);

                    if ($validator->fails()) {
                        $skippedInvalid++;
                        continue;
                    }

                    $rows[] = [
                        'id' => (string) $normalizedUser['id'],
                        'first_name' => (string) $normalizedUser['first_name'],
                        'last_name' => (string) $normalizedUser['last_name'],
                        'email' => (string) $normalizedUser['email'],
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }

                if (!empty($rows)) {
                    DB::table('imported_users')->upsert(
                        $rows,
                        ['id'],
                        ['first_name', 'last_name', 'email', 'updated_at']
                    );

                    $processedValid += count($rows);
                }
            }
        });

        return [
            'ok' => true,
            'status' => 201,
            'total_in_file' => $totalInFile,
            'processed_valid' => $processedValid,
            'skipped_invalid' => $skippedInvalid,
        ];
    }
}