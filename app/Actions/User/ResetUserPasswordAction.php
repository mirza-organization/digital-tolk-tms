<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;

final class ResetUserPasswordAction
{
    public function execute(array $userData): bool
    {
        return DB::transaction(function () use ($userData): bool {
            $user = User::getByEmail($userData['email']);

            return User::updatePassword($user, $userData['password']);
        });
    }
}
