<?php

namespace App\Http\Controllers;

use App\Mail\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }

    public function faq()
    {
        return view('pages.faq');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function send(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'message' => ['required', 'string']
        ]);
        $reciever = 'itxshakiil@gmail.com';

        Mail::to($reciever)->send(new ContactUs($request->name, $request->email, $request->message));
        return redirect('/success');
    }

    public function success()
    {
        return view('pages.success');
    }

    public function requestData()
    {
        return view('pages.request-data');
    }
}
