<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Translation\SearchTranslationAction;
use App\Actions\Translation\StoreTranslationAction;
use App\Actions\Translation\UpdateTranslationAction;
use App\Actions\Translation\ViewTranslationAction;
use App\Http\Requests\Translation\SearchTranslationRequest;
use App\Http\Requests\Translation\StoreTranslationRequest;
use App\Http\Requests\Translation\UpdateTranslationRequest;
use App\Http\Requests\Translation\ViewTranslationRequest;
use App\Services\Contracts\ResponseService;
use Illuminate\Http\JsonResponse;

class TranslationController extends Controller
{
    public function __construct(protected ResponseService $responseService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(ViewTranslationRequest $viewTranslationRequest, ViewTranslationAction $viewTranslationAction): JsonResponse
    {
        $validatedData = $viewTranslationRequest->validated();

        $data = $viewTranslationAction->execute($validatedData);

        return $this->responseService::processResponse(data: $data, showPagination: ! isset($validatedData['id']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTranslationRequest $storeTranslationRequest, StoreTranslationAction $storeTranslationAction): JsonResponse
    {
        $validatedData = $storeTranslationRequest->validated();

        $storeTranslationAction->execute($validatedData);

        return $this->responseService::processResponse(message: 'Translation created successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTranslationRequest $updateTranslationRequest, UpdateTranslationAction $updateTranslationAction): JsonResponse
    {
        $validatedData = $updateTranslationRequest->validated();

        $data = $updateTranslationAction->execute($validatedData);

        return $this->responseService::processResponse(data: $data, message: 'Translation updated successfully');
    }

    /**
     * Search the specified resource from database.
     */
    public function search(SearchTranslationRequest $searchTranslationRequest, SearchTranslationAction $searchTranslationAction): JsonResponse
    {
        $validatedData = $searchTranslationRequest->validated();

        $data = $searchTranslationAction->execute($validatedData);

        return $this->responseService::processResponse(data: $data, message: $data->isEmpty() ? 'No record found' : '');
    }
}
