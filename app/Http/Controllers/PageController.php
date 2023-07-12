<?php

namespace App\Http\Controllers;

use App\Mail\ContactUs;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    public function send(Request $request): Redirector|Application|RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string' , 'max:200'],
            'email' => ['required', 'email'],
            'message' => ['required', 'string']
        ]);

        $receiver = 'itxshakil@gmail.com';
        Mail::to($receiver)->send(new ContactUs($request->name, $request->email, $request->message));

        return redirect('/success');
    }
}
