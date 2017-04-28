<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Site;

Route::auth();

Route::get('/', function () {
    return view('welcome');
});

Route::get('/download/{file}', 'DownloadController@index');

Route::get('/contact', 'ContactController@index');
Route::post('/contact', ['as' => 'contact_submit', 'uses' => 'ContactController@submit']);
Route::get('/over', 'AboutController@index');

Route::get('/new-student', 'NewStudentController@index');
Route::post('/create-new-student', 'NewStudentController@create');

Route::get('/new-site', 'NewSiteController@index');
Route::post('/create-new-site', 'NewSiteController@create');
Route::get('/delete-site/{site_id}', 'SiteController@delete');

Route::get('/editor/{id}', 'EditorController@index');
Route::get('/editor/{id}/{split}', 'EditorController@index');

Route::get('/editor/{id}/new-page', 'EditorController@newPage');
Route::get('/editor/{id}/new-image', 'EditorController@newImage');
Route::get('/editor/{id}/page/{page_id}', 'EditorController@editPage');
Route::get('/editor/{id}/file/{file_id}', 'EditorController@file');
Route::get('/editor/{id}/delete-page/{page_id}', 'EditorController@deletePage');
Route::get('/editor/{id}/rename-page/{page_id}', 'EditorController@renamePage');
Route::get('/editor/{id}/move-file/{file_id}', 'EditorController@moveFile');
Route::get('/editor/{site_id}/toggle-published', 'SiteController@togglePublished');
Route::post('/editor/{id}/save-page/{page_id}', 'EditorController@savePage');

Route::get('/editor/{id}/move-page/{page_id}', 'EditorController@movePage');
Route::post('/editor/{id}/post-move-page', 'EditorController@postMovePage');

Route::post('/post-new-page', 'EditorController@postNewPage');
Route::post('/post-new-image', 'EditorController@postNewImage');
Route::post('/post-rename-page', 'EditorController@postRenamePage');

Route::get('/avatars/{id}/{image}', 'SiteController@viewAvatar');
Route::get('/site-settings/{id}', 'SiteController@settings');
Route::post('/post-site-settings', 'SiteController@postSettings');

Route::get('/settings', 'StudentSettingsController@index');
Route::post('/save-settings', 'StudentSettingsController@save');

Route::get('/dashboard', 'HomeController@index');
Route::post('/post-update-students', 'HomeController@postUpdateStudents');

Route::post('/post-create-portal', 'PortalController@create');
Route::get('/open-portal', 'PortalController@open');
Route::get('/manage-portals', 'PortalController@manage');

Route::get('/import-students', 'ImportStudentsController@view');

/** AJAX **/
Route::get('/auto-save/{id}/{page_id}', 'EditorController@autoSave');

/** Public **/
Route::get('/portal/{id}', 'PortalPublicViewController@view');

/** System **/
Route::get('/system-admin', 'SystemAdminController@view');

Route::get('/{slug}/afbeeldingen/{image}', 'SiteController@viewImage');
Route::get('/{slug}/{path}.{type}', 'SiteController@view');
Route::get('/{slug}/{folder}/{path}.{type}', 'SiteController@viewChild');
Route::get('/{slug}', 'SiteController@view');

// TODO page not found
