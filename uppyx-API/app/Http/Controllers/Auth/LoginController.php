<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Zend\Http\PhpEnvironment\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['only' => 'test2']);
    }

    public function test(Request $request)
    {
        return ['value' => 'hello'];
    }

    public function test2(Request $request)
    {
        return ['value' => 'with auth:api'];
    }
}