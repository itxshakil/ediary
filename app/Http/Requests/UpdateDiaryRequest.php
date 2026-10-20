<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\Mood;
use App\Enums\Privacy;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateDiaryRequest extends FormRequest
{
    /**
     * The day an entry was written is part of its history, so editing never moves it.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'entry' => ['required', 'string'],
            'title' => ['nullable', 'string', 'max:255'],
            'mood' => ['nullable', Rule::enum(Mood::class)],
            'tags' => ['nullable', 'string'],
            'privacy' => ['nullable', Rule::enum(Privacy::class)],
        ];
    }
}
