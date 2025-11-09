<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Enums\RoleEnum;
use App\Jobs\VerificationEmailJob;
use App\Models\User;
use App\Services\Contracts\EmailService;
use Illuminate\Support\Facades\DB;

final class SignUpUserAction
{
    public function __construct(public EmailService $emailService) {}

    public function execute(array $user, RoleEnum $roleEnum): array
    {
        return DB::transaction(function () use ($user, $roleEnum): array {
            $user = User::add($user, $roleEnum);

            VerificationEmailJob::dispatch($user);

            return [
                'user' => $user,
                'token' => $user->createToken('auth_token')->plainTextToken,
            ];
        });
    }
}
