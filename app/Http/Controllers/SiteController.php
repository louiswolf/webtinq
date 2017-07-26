<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Validator;
use App\Site;
use App\File;

class SiteController extends Controller
{
    const DEFAULT_AVATAR = 'logo-small.png';

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
        $site = $this->getSite($request->user(), $id);
        return view('site-settings', ['site' => $site]);
    }

    /**
     * @param $id
     * @return \App\Site
     */
    public function getSite($user, $id) {
        $site = $user->sites()->find($id);
        if ($site) {
            return $site;
        }

        if (!$site) {
            foreach ($user->students()->get() as $student) {
                if ($site = $student->sites()->find($id)) {
                    return $site;
                }
            }
        }

        return;
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

        $site = $this->getSite($request->user(), $request->site_id);

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
    public function view(Request $request, $slug, $path = '', $type = '', $folder = '')
    {
        if ($path == '' && $type == '') {
            $path = 'index';
            $type = 'html';
        }
        $sites = Site::all();

        foreach ($sites as $site) {
            if ($site->slug == $slug) {
                $pages = $site->pages()->get();
                if ($site->published) {
                    $this->showPage($pages, $path, $type, $folder);
                }

                if (!$site->published) {
                    $this->middleware('auth');

                    $user = $request->user();

                    if ($user) {
                        $is_user_teacher_for_site = $this->isUserTeacherForSite($user, $site);
                        if ($site->users()->find($user->id) || $is_user_teacher_for_site) {
                            $this->showPage($pages, $path, $type, $folder);
                        }
                    }
                }
                echo 'Toegang geweigerd';
                exit();
            }
        }

        throw new NotFoundHttpException();
    }

    public function viewChild(Request $request, $slug, $folder = '', $path = '', $type = '') {
        $this->view($request, $slug, $path, $type, $folder);
    }

    /**
     * @param Request $request
     * @param $slug
     * @param $image_name
     */
    public function viewImage(Request $request, $slug, $image_name)
    {
        $file = File::where('name', $image_name)->first();
        $file_location = 'public/avatars/' . SiteController::DEFAULT_AVATAR;
        if ($file) {
            $file_location = $file->location;
        }

        $path = '../storage/app/' . $file_location;
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
     * @param $id
     * @param $image_name
     */
    public function viewAvatar(Request $request, $id, $image_name)
    {
        $this->viewImage($request, '', $image_name);
    }

    public function viewAvatarDefault(Request $request) {
        $this->viewImage($request, '', SiteController::DEFAULT_AVATAR);
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

        $site = $this->getSite($request->user(), $site_id);
        $site->published = !$site->published;
        $site->save();

        return redirect('/site-settings/' . $site->id);
    }

    public function delete(Request $request, $site_id) {
        $this->middleware('auth');

        $site = $request->user()->sites()->find($site_id);
        $site->deleted = 1;
        $site->save();

        return redirect('/dashboard');
    }

    private function showPage($pages, $path, $type, $parentName)
    {
        if (count($pages)==0) {
            echo 'Oeps, deze website heeft nog geen pagina\'s!';
            exit();
        }

        foreach ($pages as $page) {
            if ($page->name == $path) {
                $show = false;
                if ($page->parent_id == 0 && $parentName == '') {
                    $show = true;
                } else {
                    foreach ($pages as $p) {
                        if ($p->id == $page->parent_id && $p->name == $parentName) {
                            $show = true;
                        }
                    }
                }
                if ($show) {
                    $this->setHeader($type);
                    echo $page->content;
                    exit();
                }
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
