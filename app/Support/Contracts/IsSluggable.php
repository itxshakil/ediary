<?php

declare(strict_types=1);

namespace App\Support\Contracts;

interface IsSluggable
{
    public function generateSlug(): string;

    public function generateSlugOnUpdate(): string;

    public function shouldUpdateSlug(): bool;

    public function getSlugColumn(): string;

    public function getSlugSourceColumn(): string;
}
