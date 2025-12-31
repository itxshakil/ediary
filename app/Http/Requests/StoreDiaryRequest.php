<?php

namespace App\Http\Requests;

use App\Enums\Mood;
use App\Enums\Privacy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDiaryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'entry' => ['required', 'string'],
            'title' => ['nullable', 'string', 'max:255'],
            'mood' => ['nullable', Rule::enum(Mood::class)],
            'tags' => ['nullable', 'string'],
            'privacy' => ['nullable', Rule::enum(Privacy::class)],
            'is_featured' => ['nullable', 'boolean'],
            'allow_comments' => ['nullable', 'boolean'],
            'created_at' => ['nullable', 'date'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
