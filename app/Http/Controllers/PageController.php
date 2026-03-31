<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\SendContactMessageRequest;
use App\Mail\ContactUs;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Mail;

final class PageController extends Controller
{
    public function send(SendContactMessageRequest $request): Redirector|Application|RedirectResponse
    {
        $validated = $request->validated();
        $receiver = config('mail.support.address') ?: 'itxshakil@gmail.com';
        $receiver = is_array($receiver) ? (reset($receiver) ?: 'itxshakil@gmail.com') : $receiver;

        Mail::to($receiver)->send(new ContactUs($validated['name'], $validated['email'], $validated['message']));

        return redirect('/success');
    }
}
