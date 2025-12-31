<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector;
use Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector;
use Rector\ValueObject\PhpVersion;
use RectorLaravel\Rector\FuncCall\RemoveDumpDataDeadCodeRector;
use RectorLaravel\Set\LaravelLevelSetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/app',
        __DIR__ . '/bootstrap',
        __DIR__ . '/routes',
    ])

    ->withImportNames(removeUnusedImports: true)
    ->withComposerBased(laravel: true)

    ->withPhpSets(php84: true)
    ->withPhpVersion(PhpVersion::PHP_84)

    ->withSets([
        LaravelLevelSetList::UP_TO_LARAVEL_120,
    ])

    ->withRules([
        AddReturnTypeDeclarationRector::class,
        AddParamTypeDeclarationRector::class,
    ])

    ->withConfiguredRule(RemoveDumpDataDeadCodeRector::class, [
        'dd',
        'dump',
        'var_dump',
    ])

    ->withPreparedSets(
        true,
        true,
        true,
        true,
        true,
        true,
        true,
        true,
        true,
    )->withSkip([
        RenameVariableToMatchMethodCallReturnTypeRector::class,
        RenameParamToMatchTypeRector::class,
    ]);
