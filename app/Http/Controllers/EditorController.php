<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\URL;
use Validator;
use Storage;
use App\User;
use App\Site;
use App\File;
use App\Page;
use App\Pagetype;

class EditorController extends Controller
{
    private $base_url; //'http://localhost/webtinq/public/';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->base_url = URL::to('/');
        $this->middleware('auth');
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, $id)
    {
        $user = $request->user();
        $site = $this->getSite($user, $id);
        $pages = $site->pages()->get();
        $page = $pages->get(0);

        if ($page == null) {
            $pagetype = $this->getPagetypeByName('html');
            $page = $this->createPage('index', $pagetype);
            $site->pages()->save($page);
        }

        return $this->editPage($request, $id, $page->id);
    }

    /**
     * @param Request $request
     * @param $id
     * @param $page_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editPage(Request $request, $id, $page_id)
    {
        $user = $request->user();
        $site = $this->getSite($user, $id);
        $pages = $site->pages()->get();

        $owner_id = null;
        if (isset($_GET['owner'])) {
            $owner_id = (int)$_GET['owner'];
            $files = User::find($owner_id)->files()->get();
        } else {
            $files = $user->files()->get();
        }

        $page = $pages->find($page_id);

        $this->pages = $pages->sortBy(['type']);
        $list = $this->buildTree($site->id, 0, '', '', $page_id, $owner_id);

        $list = $this->addFiles($site->id, $files, $list);

        $extension = $this->getExtension($page);
        $path = $page->name . $extension;
        $urlView = $this->getUrlView($site, $path);

        return view('/editor', [
            'id' => $id,
            'site_name' => $site->name,
            'site_slug' => $site->slug,
            'pages' => $list,
            'images' => $files,
            'page' => $page,
            'file' => null,
            'extension' => $extension,
            'published' => $site->published,
            'url_view' => $urlView,
            'path' => $this->getPath($site, $page, $extension),
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @param $page_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function renamePage(Request $request, $id, $page_id)
    {
        $user = $request->user();
        $site = $this->getSite($user, $id);
        $page = $site->pages()->find($page_id);

        return view('/rename-page', [
            'id' => $page->id,
            'name' => $page->name,
            'site_id' => $id,
            'extension' => $this->getExtension($page),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postRenamePage(Request $request)
    {
        $user = $request->user();
        $site = $this->getSite($user, $request->site_id);
        $page = $site->pages()->find($request->page_id);
        $page->name = $request->name;
        $page->save();

        return redirect('/editor/' . $request->site_id . '/page/' . $request->page_id);
    }

    /**
     * @param Request $request
     * @param $id
     * @param $page_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deletePage(Request $request, $id, $page_id)
    {
        $user = $request->user();
        $site = $this->getSite($user, $id);
        $pages = $site->pages()->get();

        $pages->find($page_id)->delete();

        return redirect('/editor/' . $id);
    }

    /**
     * @param Request $request
     * @param $id
     * @param $page_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function savePage(Request $request, $id, $page_id)
    {
        $user = $request->user();
        $site = $this->getSite($user, $id);
        $page = $site->pages()->find($page_id);

        $page->content = $request->get('content');
        $page->save();

        return redirect('/editor/' . $id . '/page/' . $page_id);
    }

    /**
     * @param Request $request
     * @param $id
     * @param $page_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function movePage(Request $request, $id, $page_id)
    {
        $user = $request->user();
        $site = $this->getSite($user, $id);
        $pages = $site->pages()->get();
        $page = $pages->find($page_id);

        $folders = array();
        foreach ($pages as $p) {
            if ($p->type->name == '/') {
                $folders[] = $p;
            }
        }

        return view('/move-page', [
            'id' => $page->id,
            'name' => $page->name,
            'site_id' => $id,
            'folders' => $folders,
            'extension' => $this->getExtension($page),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postMovePage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'site_id' => 'required|integer',
            'page_id' => 'required|integer',
            'parent_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect('/editor/' . $request->site_id . '/move-page')
                ->withInput()
                ->withErrors($validator);
        }

        if (!$validator->fails()) {
            $user = $request->user();
            $site = $this->getSite($user, $request->site_id);
            $page = $site->pages()->find($request->page_id);
            $page->parent_id = $request->parent_id;
            $page->save();
            return redirect('/editor/' . $request->site_id . '/page/' . $request->page_id);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newPage(Request $request, $id)
    {
        $pagetypes = Pagetype::all();
        return view('/new-page', [
            'id' => $id,
            'pagetypes' => $pagetypes,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postNewPage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'site_id' => 'required|integer',
            'name' => 'required|max:255',
            'extension' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect('/editor/' . $request->site_id . '/new-page')
                ->withInput()
                ->withErrors($validator);
        }

        if (!$validator->fails()) {
            $user = $request->user();
            $site = $this->getSite($user, $request->site_id);

            $name = $request->name;
            $pageType = Pagetype::all()->find($request->extension);

            $page = $this->createPage($name, $pageType);
            $site->pages()->save($page);

            return redirect('/editor/' . $site->id . '/page/' . $page->id);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newImage(Request $request, $id)
    {
        $user = $request->user();
        $site = $this->getSite($user, $id);
        $pages = $site->pages()->get();
        $folders = array();
        foreach ($pages as $page) {
            if ($page->type->name == '/') {
                $folders[] = $page;
            }
        }

        return view('/new-image', [
            'id' => $id,
            'folders' => $folders,
        ]);
    }

    public function postNewImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'images' => 'mimes:png,jpeg,gif,bmp',
            'parent_folder' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect('/new-image')
                ->withInput()
                ->withErrors($validator);
        }

        if (!$validator->fails()) {
            $user = $request->user();

            $filename = Input::file('image')->getClientOriginalName();
            $uri = 'public/uploads/' . $filename;
            if (!empty($request->file('image'))) {

                try {
                    $file = File::create([
                        'name' => $filename,
                        'location' => $uri,
                    ]);

                    if (!file_exists($uri)) {
                        Storage::put(
                            $uri,
                            file_get_contents($request->file('image')->getRealPath())
                        );
                    }

                    $user->files()->save($file);
                } catch (\PDOException $e) {
                    return redirect('/editor/' . $request->site_id)->withErrors(
                        array('message' => 'Een afbeelding met deze naam bestaat al.')
                    );
                }
            }
        }
        return redirect('/editor/' . $request->site_id);
    }

    /**
     * @param Request $request
     * @param $site_id
     * @param $file_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function file(Request $request, $site_id, $file_id)
    {
        $user = $request->user();
        $site = $this->getSite($user, $site_id);
        $pages = $site->pages()->get();
        $files = $user->files()->get();
        $file = $files->find($file_id);

        $this->pages = $pages->sortBy('type');
        $list = $this->buildTree($site->id, 0, '', '', $file_id);
        $list = $this->addFiles($site->id, $files, $list);

        return view('/editor', [
            'id' => $site_id,
            'site_name' => $site->name,
            'site_slug' => $site->slug,
            'pages' => $list,
            'page' => null,
            'file' => $file,
            'extension' => '',
            'published' => $site->published,
            'url_view' => '$urlView',
            'path' => $this->base_url . '/' . $site->slug . '/afbeeldingen/' . $file->name,
        ]);
    }

    private function getSite($user, $id)
    {
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

    private function addFiles($site_id, $files, $list)
    {
        if (count($files) > 0) {
            $list .= '<li>afbeeldingen/</li>';
            foreach ($files as $file) {
                $url = $this->getTreeListUrl($site_id, 'file', $file->id);
                $list .= $this->getTreeListItem('', '&nbsp;&rdsh;&nbsp;', $url, $file->name);
            }
        }
        return $list;
    }

    private function buildTree($site_id, $parent_id, $tree, $indent, $current_id, $owner_id = null)
    {
        foreach ($this->pages as $key => $page) {
            if ($parent_id == $page->parent_id) {
                $extension = $this->getExtension($page);

                $class = ($page->id == $current_id ? 'active' : '');
                $url = $this->getTreeListUrl($site_id, 'page', $page->id, $owner_id);
                $title = $page->name . $extension;

                $tree .= $this->getTreeListItem($class, $indent, $url, $title);

                $this->pages->forget($key);
                if ($page instanceof Page) {
                    $children = $page->getChildren()->get();
                    $files = $page->getFiles()->get();
                    $children = $children->merge($files);
                    if (count($children) > 0) {
                        $new_indent = str_replace('&rdsh;', '&nbsp;&nbsp;&nbsp;', $indent);
                        $new_indent .= '&nbsp;&rdsh;&nbsp;';
                        $tree = $this->buildTree($site_id, $page->id, $tree, $new_indent, $current_id, $owner_id);
                    }
                }
            }
        }
        return $tree;
    }

    private function getTreeListUrl($site_id, $infix, $page_id, $owner_id = null)
    {
        return $this->base_url . '/editor/' . $site_id . '/' . $infix . '/' . $page_id . ($owner_id ? '?owner=' . $owner_id : '');
    }

    private function getTreeListItem($class, $indent, $url, $title)
    {
        return '<li class="' . $class . '"><span style="color:#ccc;">' . $indent . '</span><a href="' . $url . '">' . $title . '</a></li>' . "\n";
    }

    private function getPath($site, $page, $extension)
    {
        return $this->base_url . '/' . $site->slug . '/' . $page->name . $extension;
    }

    private function getUrlView($site, $path)
    {
        return $site->slug . '/' . $path;
    }

    private function getPagetypeByName($name)
    {
        foreach (Pagetype::all() as $pagetype) {
            if ($pagetype->name == $name)
                return $pagetype;
        }
    }

    private function createPage($name, $pagetype)
    {
        $content = '';
        switch ($pagetype->name) {
            case 'html':
                $content =
                    '<!DOCTYPE html>
<html lang="nl">
    <head>
        <title>WebTinq</title>
    </head>
    <body>
        <p>WebTinq</p>
    </body>
</html>';
                break;
            case 'css':
                $content =
                    '.body {
    font-size: 12px;
    font-family: arial,verdana,helvetica;
    background-color: green;
}';
                break;
            case '/':
                $content = '';
                break;
        }

        $page = Page::create([
            'name' => $name,
            'content' => $content,
            'type_id' => $pagetype->id,
            'published' => false,
        ]);
        return $page;
    }

    private function getExtension($page)
    {
        $infix = '';
        if ($page->type->name != '/') {
            $infix = '.';
        }
        return $infix . $page->type->name;
    }
}