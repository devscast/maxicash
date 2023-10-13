<?php

declare(strict_types=1);

use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return function (ECSConfig $ecsConfig): void {
    $ecsConfig->paths([
        __DIR__ . '/src',
    ]);

    $ecsConfig->sets([
        SetList::PSR_12,
        SetList::COMMON,
        SetList::CLEAN_CODE
    ]);

    $ecsConfig->skip([
        PhpCsFixer\Fixer\FunctionNotation\MethodArgumentSpaceFixer::class
    ]);
};
