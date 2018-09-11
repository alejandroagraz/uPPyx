<?php

namespace App\Http\Controllers;

use App\User;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Input;
use Illuminate\Support\Facades\Auth;
use App\Validations\UserValidations;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function login(Request $request)
    {
        $data = $request->all();
        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password'], 'deleted_at' => null])) {
            $user = Auth::user();
            if ($user->hasRole('agent') || $user->hasRole('user')) {
                Auth::logout();
                return redirect()->back()->withInput($request->only($this->username(), 'remember'))
                    ->with('status', 'Usted no cuenta con los permisos para acceder');
            }
            if ($user->status != 1) {
                Auth::logout();
                return redirect()->back()->withInput($request->only($this->username(), 'remember'))
                    ->with('status', 'Este usuario se encuentra inhabilitado');
            }
            return redirect('/');
        } else {
            $validator = UserValidations::getUserLoginValidation($data);
            if ($validator->fails()) {
                return redirect()->back()->withInput($request->only($this->username(), 'remember'))
                    ->withErrors($validator);
            }
            $message = $this->sendFailedLoginResponse($request);
            return redirect()->back()->withInput($request->only($this->username(), 'remember'))
                ->with('status', $message);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request)
    {
        Session::flush();
        return redirect('/');
    }

    /**
     * @param Request $request
     * @return string
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        if (!User::where('email', $request->email)->first()) {
            $message = Lang::get('auth.email');
        }
        elseif (!User::where('email', $request->email)->where('password', bcrypt($request->password))->first()) {
            $message = Lang::get('auth.password');
        } else {
            $message = "";
        }
        return $message;
    }

    /**
     * @return string
     */
    protected function username() {
        return "email";
    }
}