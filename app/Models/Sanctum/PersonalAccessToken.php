<?php

declare(strict_types=1);

namespace App\Models\Sanctum;

use Laravel\Sanctum\PersonalAccessToken as LaravelSanctumPersonalAccessToken;
use MongoDB\Laravel\Eloquent\DocumentModel as MongoDBDocumentModel;

class PersonalAccessToken extends LaravelSanctumPersonalAccessToken
{
    use MongoDBDocumentModel;

    protected $connection = 'mongodb';

    protected $table = 'personal_access_tokens';

    protected $primaryKey = '_id';

    protected $keyType = 'string';
}
