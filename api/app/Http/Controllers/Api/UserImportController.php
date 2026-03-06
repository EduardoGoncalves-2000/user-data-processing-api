<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportUsersRequest;
use App\Services\UserImportService;

class UserImportController extends Controller
{
    public function import(ImportUsersRequest $request, UserImportService $service)
    {
        $file = $request->file('file');

        if (!$file->isValid()) {
            return response()->json([
                'error' => 'Falha ao enviar o arquivo.',
            ], 400);
        }

        $json = file_get_contents($file->getRealPath());

        $result = $service->importFromJsonString($json);

        if (!$result['ok']) {
            return response()->json([
                'error' => $result['error'],
            ], $result['status']);
        }

        return response()->json([
            'message' => 'Importação concluída com sucesso.',
            'total_in_file' => $result['total_in_file'],
            'processed_valid' => $result['processed_valid'],
            'skipped_invalid' => $result['skipped_invalid'],
        ], 201);
    }
}