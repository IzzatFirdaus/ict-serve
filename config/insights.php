<?php

declare(strict_types=1);

use NunoMaduro\PhpInsights\Domain\Insights\ForbiddenFinalClasses;
use NunoMaduro\PhpInsights\Domain\Metrics\Architecture\Classes;

return [
    'preset' => 'laravel',
    'ide' => null,
    'exclude' => [
        'storage', 'vendor', 'node_modules', 'public/build',
    ],
    'add' => [
        Classes::class => [ForbiddenFinalClasses::class],
    ],
    'remove' => [
        // Trim noisy sniffs already handled by Pint / Larastan
    ],
    'config' => [],
    'requirements' => [],
    'threads' => null,
    'timeout' => 90,
];
