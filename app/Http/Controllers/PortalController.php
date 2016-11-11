<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Validator;
use App\User;
use App\Portal;

class PortalController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function manage(Request $request)
    {
        return view('manage-portals', ['user' => $request->user()]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'portal_name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect('/dashboard')
                ->withInput()
                ->withErrors($validator);
        }

        $portal = Portal::create();
        $portal->name = $request->portal_name;

        $request->user()->portals()->save($portal);
        $students = User::findMany($request->student)->all();
        $portal->students()->saveMany($students);

        return redirect('manage-portals');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function open(Request $request)
    {
        $user = $request->user();
        $ids = array();
        if (isset($request->student)) {
            $ids = $request->student;
        }

        $students = array();
        foreach ($user->students()->get() as $student) {
            if (in_array($student->id, $ids)) {
                $students[] = $student;
            }
        }

        return view('open-portal', ['students' => $students]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view(Request $request, $id)
    {
        $portal = Portal::find($id);

        return view('portal', ['portal' => $portal]);
    }
}