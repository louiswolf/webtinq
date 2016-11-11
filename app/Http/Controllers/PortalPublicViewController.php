<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Portal;

class PortalPublicViewController extends Controller
{
    /**
     * Create a new portalpublicviewcontroller instance.
     *
     */
    public function __construct()
    {
    }

    public function view(Request $request, $id)
    {
        $portal = Portal::find($id);

        return view('portal', ['portal' => $portal]);
    }
}