<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Validator;
use Storage;
use App\File;
use App\User;

class StudentSettingsController extends Controller
{

    const SYSTEM_ADMIN = 1;

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
    public function index(Request $request)
    {
        $user = $request->user();
        if (isset($_GET['owner'])) {
            $user = User::find((int)$_GET['owner']);
        }
        return view('/settings', ['user' => $user]);
    }

    /**
     * Save student settings.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function save(Request $request)
    {
        $user = User::find($request->user_id);

        $password = $request->password1;

        $validator = Validator::make($request->all(), [
            'avatar' => 'mimes:png,jpeg,gif,bmp',
            'password1' => 'same:password2|min:6',
        ]);

        if ($validator->fails()) {
            return redirect('/settings')
                ->withInput()
                ->withErrors($validator);
        }

        if (!$validator->fails()) {
            if (!empty($request->file('avatar'))) {
                $filename = Input::file('avatar')->getClientOriginalName();
                $uri = 'public/avatars/' . $user->id . '/' . $filename;

                try {
                    $file = File::create([
                        'name' => $filename,
                        'location' => $uri,
                    ]);

                    if (!file_exists($uri)) {
                        Storage::put(
                            $uri,
                            file_get_contents($request->file('avatar')->getRealPath())
                        );
                    }

                    $user->files()->save($file);
                    $user->avatar_file_id = $file->id;
                    $user->save();
                } catch (\PDOException $e) {
                    return redirect('/settings?owner=' . $user->id)->withErrors(
                        array('message' => 'Een afbeelding met deze naam bestaat al.')
                    );
                }
            }

            if (!empty($password)) {
                $user->password = bcrypt($password);
                if (!$user->status() == StudentSettingsController::SYSTEM_ADMIN) {
                    $user->password_unencrypted = $password;
                }
                $user->save();
            }
        }

        return view('/settings', ['user' => $user]);
    }
}
