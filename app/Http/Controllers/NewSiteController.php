<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Validator;
use App\Site;

class NewSiteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('/new-site');
    }

    /**
     * Save a new student.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'slug' => 'required|max:255',
        ]);

        if (!$validator->fails()) {

            $site = Site::create([
                'name' => $request->name,
                'slug' => $request->slug,
            ]);

            $request->user()->sites()->save($site);

            return redirect('/dashboard');
        }

        /* If validator fails */
        return redirect('/new-site')
            ->withInput()
            ->withErrors($validator);
    }
}
