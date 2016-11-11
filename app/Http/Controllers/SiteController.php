<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Validator;
use App\Site;
use App\File;

class SiteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function settings(Request $request, $id)
    {
        $this->middleware('auth');

        $site = $request->user()->sites()->find($id);
        return view('site-settings', ['site' => $site]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postSettings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'site_id' => 'required|integer',
            'site_name' => 'required|string',
            'site_slug' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect('/site-settings/' . $request->site_id)
                ->withInput()
                ->withErrors($validator);
        }

        $site = $request->user()->sites()->find($request->site_id);

        $site->name = $request->site_name;
        $site->slug = $request->site_slug;
        $site->save();

        return redirect('/site-settings/' . $site->id);
    }

    /**
     * @param Request $request
     * @param $slug
     * @param $path
     * @param $type
     */
    public function view(Request $request, $slug, $path, $type)
    {
        $sites = Site::all();
        foreach ($sites as $site) {
            if ($site->slug == $slug) {
                $pages = $site->pages()->get();
                if ($site->published) {
                    $this->showPage($pages, $path, $type);
                }

                if (!$site->published) {
                    $this->middleware('auth');

                    $user = $request->user();
                    if ($user) {
                        $is_user_teacher_for_site = $this->isUserTeacherForSite($user, $site);
                        if ($site->users()->find($user->id) || $is_user_teacher_for_site) {
                            $this->showPage($pages, $path, $type);
                        }
                    }

                }
                echo 'Toegang geweigerd';
                exit();
            }
        }

        echo 'pagina niet gevonden';
        exit();
    }

    /**
     * @param Request $request
     * @param $slug
     * @param $image_name
     */
    public function viewImage(Request $request, $slug, $image_name)
    {
        $file = File::where('name', $image_name)->first();
        $path = '../storage/app/' . $file->location;
        if (file_exists($path)) {
            $imageInfo = getimagesize($path);
            switch ($imageInfo[2]) {
                case IMAGETYPE_JPEG:
                    header("Content-Type: image/jpeg");
                    break;
                case IMAGETYPE_GIF:
                    header("Content-Type: image/gif");
                    break;
                case IMAGETYPE_PNG:
                    header("Content-Type: image/png");
                    break;
                default:
                    break;
            }

            header('Content-Length: ' . filesize($path));
            readfile($path);

        }
    }

    /**
     * @param Request $request
     * @param $site_id
     * @param int $page_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function togglePublished(Request $request, $site_id, $page_id = 0)
    {
        $this->middleware('auth');

        $site = $request->user()->sites()->find($site_id);
        $site->published = ($site->published == 0 ? 1 : 0);
        $site->save();

        return redirect('/site-settings/' . $site->id);
    }

    private function showPage($pages, $path, $type)
    {
        foreach ($pages as $page) {
            if ($page->name == $path) {
                $this->setHeader($type);
                echo $page->content;
                exit();
            }
        }
    }

    private function setHeader($type)
    {
        switch ($type) {
            case 'css':
                header('Content-Type: text/css; charset=UTF-8');
                break;
            default:
                header('Content-Type: text/html; charset=UTF-8');
                break;
        }
    }

    private function isUserTeacherForSite($user, $site)
    {
        foreach ($user->students()->get() as $student) {
            if ($site->users()->find($student->id)) {
                return true;
            }
        }
        return false;
    }
}
