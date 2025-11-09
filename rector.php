<?php

use Rector\Config\RectorConfig;
use Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector;
use Rector\Php74\Rector\Closure\ClosureToArrowFunctionRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/app',
        __DIR__.'/routes',
        __DIR__.'/tests',
    ])
    ->withPhpSets()
    ->withImportNames()
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        naming: true,
        instanceOf: true,
        earlyReturn: true,
        strictBooleans: true,
        typeDeclarations: true,
        rectorPreset: true,
    )
    ->withSkip([
        RenameVariableToMatchMethodCallReturnTypeRector::class,
        ClosureToArrowFunctionRector::class,
    ]);
