<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\User\LoginUserAction;
use App\Http\Requests\User\LoginUserRequest;
use App\Services\Contracts\ResponseService;
use Illuminate\Http\JsonResponse;

class AuthenticationController extends Controller
{
    public function __construct(protected ResponseService $responseService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function login(LoginUserRequest $loginUserRequest, LoginUserAction $loginUserAction): JsonResponse
    {
        $validatedData = $loginUserRequest->validated();

        $data = $loginUserAction->execute($validatedData);

        return $this->responseService::processResponse(data: $data, message: 'LoggedIn successfully..!!');
    }
}
