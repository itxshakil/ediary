<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('checkusername');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function checkusername(Request $request)
    {
        if (strlen($request->username) < 5) {
            return response('false');
        }

        if (User::where('username', $request->username)->exists()) {
            return response('false');
        }
        return response('true');
    }
}
