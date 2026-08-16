<?php

declare(strict_types=1);

exec('git config core.hooksPath .hooks');

if (PHP_OS_FAMILY !== 'Windows') {
    @chmod(__DIR__ . '/../.hooks/pre-commit', 0755);
}
