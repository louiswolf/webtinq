<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Site;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $is_teacher = false;
        $is_student = false;

        foreach ($user->roles as $role) {
            if ($role->name === 'teacher') {
                $is_teacher = true;
            }
            if ($role->name === 'student') {
                $is_student = true;
            }
        }

        if ($is_student) {
            if ($user->password_unencrypted == 'webtinq') {
                return redirect('/settings')->with(
                    array('warning' => '<b>Let op!</b> Verander je wachtwoord voordat je verder gaat.')
                );
            }
            $sites = $user->sites()->get();
            return view('dashboard-student', ['sites' => $sites, 'user_status' => $user->status(),]);
        }

        $students = $user->students()->get();
        return view('home', ['students' => $students, 'user_status' => $user->status(),]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postUpdateStudents(Request $request)
    {
        $user = $request->user();

        if ($request->get('print_logins')) {
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

            $pdf = \PDF::loadView('print-logins', array('students' => $students));
            return $pdf->download('logins.pdf');
        }

        if ($request->get('open_portal')) {
            return redirect()->action('PortalController@open', ['student' => $request->student]);
        }

        if ($request->get('manage_portals')) {
            return redirect('manage-portals');
        }

        $this->performUpdatePublish($request);
        $this->performUpdateBlock($request);
        return redirect('/dashboard');
    }

    private function performUpdatePublish(Request $request)
    {
        $ids = array();
        if (isset($request->publish)) {
            $ids = $request->publish;
        }

        $user = $request->user();
        foreach ($user->students()->get() as $student) {
            foreach ($student->sites()->get() as $site) {
                if (in_array($site->id, $ids)) {
                    if (!$site->published) {
                        $site->published = true;
                        $site->save();
                    }
                } else {
                    if ($site->published) {
                        $site->published = false;
                        $site->save();
                    }
                }
            }
        }
    }

    private function performUpdateBlock(Request $request)
    {
        $ids = array();
        if (isset($request->block)) {
            $ids = $request->block;
        }

        $user = $request->user();
        foreach ($user->students()->get() as $student) {
            foreach ($student->sites()->get() as $site) {
                if (in_array($site->id, $ids)) {
                    if (!$site->blocked) {
                        $site->blocked = true;
                        $site->save();
                    }
                } else {
                    if ($site->blocked) {
                        $site->blocked = false;
                        $site->save();
                    }
                }
            }
        }
    }
}
