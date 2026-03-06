<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ImportedUser;

class UserController extends Controller
{
    public function show(string $id)
    {
        $user = ImportedUser::find($id);

        if (!$user) {
            return response()->json([
                'error' => 'Usuário não encontrado.',
            ], 404);
        }

        return response()->json([
            'user' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
            ],
        ], 200);
    }
}