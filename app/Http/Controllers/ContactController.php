<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use Validator;

class ContactController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
    }

    public function index(Request $request)
    {
        return view('/contact');
    }

    public function submit(Requests\SubmitContactForm $request) {
        \Mail::send('emails.contact',
            array(
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'user_message' => $request->get('message')
            ), function($message)
            {
                $message->from('info@webtinq.nl');
                $message->to('info@webtinq.nl', 'Admin')->subject('WebTinq webformulier');
            });

        return redirect('contact')->with('message', 'Bedankt voor uw bericht!');
    }
}
