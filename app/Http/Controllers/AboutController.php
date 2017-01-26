<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use Validator;

class AboutController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
    }

    public function index(Request $request)
    {
        return view('/about');
    }
}
