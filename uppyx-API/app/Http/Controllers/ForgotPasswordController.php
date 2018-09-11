<?php

namespace App\Http\Controllers;

use DB;
use Mail;
use Auth;
use App\User;
use Webpatser\Uuid\Uuid;
use App\Libraries\General;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Validations\ForgotPasswordValidations;

class ForgotPasswordController extends Controller
{
    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|mixed
     */
    public function sendValidationToken(Request $request)
    {
        $data = $request->all();

        $validator = ForgotPasswordValidations::sendValidationTokenValidation($data, $request);
        if ($validator->fails()) {
            if (count($request->json()) > 0) {
                return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
            } else {
                return redirect()->back()->withErrors($validator->messages())->withInput();
            }
        }
        $user = User::whereEmail($request->email)->first();
        if (count($user) > 0) {
            if(count($user->socialLogins) > 0) {
                return General::responseErrorAPI(trans('messages.UserSocial'), 'UserSocial', 400);
            }
            //send email to user.
            $token = Uuid::generate(4);
            $newPassword = General::randomPassword();

            Mail::send('validationToken', ['user' => $user, 'token' => $token, 'password' => $newPassword,
                'lang' => $request->lang], function ($m) use ($user, $request) {
                $m->from(env('APP_EMAIL'), 'uPPyx');
                $m->to($user->email, $user->name)->subject(trans('messages.Email-Validation-Code'));
            });
            if (count(Mail::failures()) > 0) {
                if (count($request->json()) > 0) {
                    return General::responseErrorAPI(trans('messages.ErrorSendingEmail'), 'ErrorSendingEmail', 400);
                } else {
                    return redirect()->back()->withErrors(trans('messages.ErrorSendingEmail'))->withInput();
                }
            } else {
                //save token to restore password
                self::saveTokenResetPassword($user, $token);
                //return info
                if (count($request->json()) > 0) {
                    return General::responseSuccessAPI('sent', false);
                } else {
                    return redirect('password/reset')->with('success', 'Hemos enviado un email para que cambie su contraseña.');
                }
            }
        } else {
            //user doesn't exists
            if (count($request->json()) > 0) {
                return General::responseErrorAPI(trans('messages.UserNotFoundForgot'), 'UserNotFoundForgot', 400);
            } else {
                return redirect('password/reset')->with('error', 'Este usuario no se encuentra registrado');
            }
        }
    }

    /**
     * @param $user
     * @param $code
     */
    public static function saveTokenResetPassword($user, $code)
    {
        //save password reset token
        $resetPassword = new PasswordReset();
        $resetPassword->email = $user->email;
        $resetPassword->token = $code;
        $resetPassword->created_at = date('Y-m-d H:i:s');
        $resetPassword->save();
    }

    /**
     * @param Request $request
     * @param $token
     * @return mixed
     */
    public function validateToken(Request $request, $token)
    {

        $request->merge(['token' => $token]);
        $data = $request->all();
        $validator = ForgotPasswordValidations::validateTokenValidation($data);
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $verifyToken = PasswordReset::whereToken($token)->first([DB::raw('DATE(created_at) AS date'), 'email']);
        if (!$verifyToken) {
            return General::responseErrorAPI(trans('messages.InvalidPasswordToken'), 'InvalidPasswordToken', 400);
        } else {
            $elapsedDays = General::elapsedDays($verifyToken->date);
            if ($elapsedDays >= 1) {
                return General::responseErrorAPI(trans('messages.PasswordExpired'), 'PasswordExpired', 400);
            }
        }
        $user = User::whereEmail($verifyToken->email)->first();
        if ($user) {
            $user->password = $data['password'];
            $user->save();
            PasswordReset::whereToken($token)->delete();
            return General::responseErrorAPI(trans('messages.PasswordChanged'), 'PasswordChanged', 200);
        } else {
            //user doesn't exists
            return General::responseErrorAPI(trans('messages.UserNotFoundForgot'), 'UserNotFoundForgot', 400);
        }
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function resetPassword(Request $request)
    {

        $validator = ForgotPasswordValidations::resetPasswordValidation($request);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->messages())->withInput();
        } else {
            $existsToken = PasswordReset::whereToken($request->token)->whereEmail($request->email)->first();
            if ($existsToken) {
                $user = User::whereEmail($request->email)->first();
                $user->password = bcrypt($request->password);
                if ($user->save()) {
                    $existsToken->whereToken($request->token)->delete();

                    if ($user->hasRole('user') || $user->hasRole('agent')) {
                        return redirect('password-changed')->with('success', '¡Tú contraseña ha sido cambiada con éxito!');
                    } else {
                        if (Auth::attempt(['email' => $user->email, 'password' => $request->password])) {
                            return redirect('/');
                        }
                    }
                } else {
                    return redirect('password-changed')->with('error', 'No se ha podido actualizar la contraseña');
                }
            } else {
                return redirect('password-changed')->with('error', 'El token ya no está disponible.');
            }
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function passwordChanged()
    {
        if (session('error') || session('success')) {
            return view('auth.passwords.password-changed');
        } else {
            return redirect('/');
        }
    }
}
