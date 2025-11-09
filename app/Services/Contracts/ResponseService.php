<?php

declare(strict_types=1);

namespace App\Services\Contracts;

use App\Enums\HttpStatusEnum;

interface ResponseService
{
    public static function processResponse(
        mixed $data = [],
        ?bool $showPagination = false,
        array|string $message = '',
        HttpStatusEnum $httpStatusEnum = HttpStatusEnum::OK
    );
}
