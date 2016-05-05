<?php

namespace App\Http\Controllers;

use App\User;
use App\Category;
use App\Mailers\AppMailers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\RegistrationRequest;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */



    /**
     * Get the Registration View.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getRegister() {
        // Gets the query string from our form submission
        $query = Input::get('search');

        // Returns an array of products that have the query string located somewhere within
        // our products product name. Paginates them so we can break up lots of search results.
        $search = \DB::table('products')->where('product_name', 'LIKE', '%' . $query . '%')->paginate(10);

        return view('auth.register', compact('query', 'search'));
    }


    /**
     * Validate and create the user in the Database.
     *
     * @param RegistrationRequest $request
     * @param AppMailers $mailer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postRegister(RegistrationRequest $request, AppMailers $mailer) {

        // Create the user in the DB.
        $user = User::create([
            'email' => $request->input('email'),
            'username' => $request->input('username'),
            'password' => bcrypt($request->input('password')),
            'verified' => 0,
        ]);

        /**
         * send email conformation to user that just registered.
         * -- sendEmailConfirmationTo is in Mailers/AppMailers.php --
         */
        $mailer->sendEmailConfirmationTo($user);

        // Flash a info message saying you need to confirm your email.
        flash()->overlay('Info', 'Please confirm your email address in your inbox.');

        return redirect()->back();

    }


    /**
     * Get the user token, an make check id email is confirmed.
     * -- confirmEmail located in User.php Model.
     *
     * @param $token
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function confirmEmail($token) {
        // Get the user with token, or fail.
        User::whereToken($token)->firstOrFail()->confirmEmail();

        // Flash a info message saying you need to confirm your email.
        flash()->success('Success', 'You are now confirmed. Please sign in.');

        return redirect('/');
    }


    /** ----------------------------------------------------------------------------------- */



    /**
     * Get the Login View.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getLogin() {
        // Gets the query string from our form submission
        $query = Input::get('search');

        // Returns an array of products that have the query string located somewhere within
        // our products product name. Paginates them so we can break up lots of search results.
        $search = \DB::table('products')->where('product_name', 'LIKE', '%' . $query . '%')->paginate(10);

        return view('auth.login', compact('query', 'search'));
    }


    /**
     * Login the user.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postLogin(Request $request) {

        // Validate email and password.
        $this->validate($request, [
            'email'    => 'required|email',
            'password' => 'required|'
        ]);

        // login in user if successful
        if ($this->signIn($request)) {
            //flash()->success('Success', 'You have successfully signed in.');
            return redirect('/');
        }

        // Else, show error message, and redirect them back to login.php.
        flash()->customErrorOverlay('Error', 'Could not sign you in with those credentials');

        return redirect('login');
    }


    /**
     * Attempt to sign in the user.
     *
     * @param  Request $request
     * @return boolean
     */
    protected function signIn(Request $request) {
        return Auth::attempt($this->getCredentials($request), $request->has('remember'));
    }


    /**
     * Get the user credentials to login.
     *
     * @param Request $request
     * @return array
     */
    protected function getCredentials(Request $request) {
        return [
            'email'    => $request->input('email'),
            'password' => $request->input('password'),
            'verified' => true
        ];
    }


    /**
     * Logout user.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout() {
        Auth::logout();
        return redirect('/');
    }


}
