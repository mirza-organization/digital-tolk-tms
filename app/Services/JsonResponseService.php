<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\HttpStatusEnum;
use App\Services\Contracts\ResponseService;
use Illuminate\Http\JsonResponse;

final class JsonResponseService implements ResponseService
{
    public static function processResponse(
        mixed $data = [],
        ?bool $showPagination = false,
        array|string $message = '',
        HttpStatusEnum $httpStatusEnum = HttpStatusEnum::OK
    ): JsonResponse {
        $response['data'] = ($showPagination === true) ? $data->items() : (is_array($data) ? (object) $data : $data);

        if ($showPagination === true) {
            $pagination = $data->toArray();
            unset($pagination['data']);
            $response['pagination'] = $pagination;
        }

        $response['message'] = $message;

        return response()->json($response, $httpStatusEnum->value);
    }
}
