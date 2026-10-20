<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

final class JournalPromptController
{
    public function index(): View
    {
        return view('journal-prompts.index', ['pages' => config('journal-prompts.pages')]);
    }

    public function show(string $slug): View
    {
        $page = config("journal-prompts.pages.{$slug}");
        abort_if($page === null, 404);

        return view('journal-prompts.show', ['slug' => $slug, 'page' => $page]);
    }
}
