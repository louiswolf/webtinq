<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use Validator;

class NewStudentController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('/new-student');
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
        ]);

        if ($validator->fails()) {
            return redirect('/new-student')
                ->withInput()
                ->withErrors($validator);
        }

        $password = 'webtinq';
        $user = User::create([
            'name' => $request->name,
            'email' => $request->name . '@webtinq.nl',
            'password' => bcrypt($password),
            'password_unencrypted' => $password,
        ]);

        $role = Role::find(2);
        $user->roles()->save($role);

        $request->user()->students()->save($user);
        return redirect('/new-student')->with(
            array('success' => 'Nieuw leerling account voor ' . $user->name .' aangemaakt.')
        );
    }
}
