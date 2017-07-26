<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use Validator;

class DownloadController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
    }

    public function index(Request $request, $file)
    {
        if ( $file === 'instruction' ) {
            return response()->file(public_path().'_html/webtinq-leerling-instructie.pdf');
        }

        if ( $file === 'grant-request' ) {
            return response()->file(public_path().'_html/sidn-fonds-aanvraag-online.pdf');
        }
    }
}
