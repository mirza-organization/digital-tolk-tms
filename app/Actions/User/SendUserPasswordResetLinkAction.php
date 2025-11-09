<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Jobs\PasswordResetEmailJob;
use App\Models\User;
use App\Services\Contracts\EmailService;
use Illuminate\Support\Facades\Password;

final class SendUserPasswordResetLinkAction
{
    public function __construct(public EmailService $emailService) {}

    public function execute(string $email): bool
    {
        $user = User::getByEmail($email);

        $token = Password::createToken($user);

        PasswordResetEmailJob::dispatch($user, $token);

        return true;
    }
}
