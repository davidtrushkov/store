<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $user;

    /**
     * Make a constructor to initialize Auth check.
     */
    public function __construct() {
        // set user = to the currently authenticated user.
        $this->user = Auth::user();

        view()->share('signedIn', Auth::check());
        view()->share('user', $this->user);
    }
}
