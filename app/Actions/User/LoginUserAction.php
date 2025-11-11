<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

final class LoginUserAction
{
    public function execute(array $credentials): array
    {
        $user = User::getByEmail($credentials['email']);

        if (! Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'error' => ['The provided password is incorrect.'],
            ]);
        }

        return [
            'user' => $user,
            'token' => $user->createToken('auth_token')->plainTextToken,
        ];
    }
}
