<?php

declare(strict_types=1);

namespace App\Enums;

enum TranslationTagEnum: string
{
    case MOBILE = 'mobile';
    case WEB = 'web';
    case DESKTOP = 'desktop';
}
