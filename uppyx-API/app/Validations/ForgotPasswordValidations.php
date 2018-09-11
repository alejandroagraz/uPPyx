<?php

namespace App\Validations;


class ForgotPasswordValidations
{


    /**
     * @param $data
     * @param $request
     * @return mixed
     */
    public static function sendValidationTokenValidation($data, $request)
    {
        $rules = [];
        $rules['email'] = 'required|email';
        if (count($request->json()) > 0) {
            $rules['lang'] = 'required';
            $rules['grant_type'] = 'required';
            $rules['client_id'] = 'required';
            $rules['client_secret'] = 'required';
        }

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function validateTokenValidation($data)
    {
        $rules = [];
        $rules['token'] = 'required';
        $rules['password'] = 'required';
        $rules['password_confirmation'] = 'required_with:password|min:6';

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    /**
     * @param $request
     * @return mixed
     */
    public static function resetPasswordValidation($request)
    {
        $data = $request->toArray();

        $messages = [
            'password_confirmation.max' => 'Este campo no puede ser mayor a 20 caracteres.',
            'password_confirmation.min' => 'Este campo no puede ser menor a 6 caracteres.',
        ];

        $rules = [];
        $rules['email'] = 'required|email';
        $rules['token'] = 'required';
        $rules['password'] = 'required|confirmed';
        $rules['password_confirmation'] = 'required_with:password|min:6|max:20';

        $validator = \Validator::make($data, $rules, $messages);
        return $validator;
    }

    /**
     * @param $request
     * @return
     * @internal param $id
     */
    public static function resetProfileValidation($request)
    {

        $data = $request->toArray();
        $messages = [
            'password.required' => 'Este campo no puede estar vacío.',
            'password.max' => 'Este campo debe contener máximo 20 caracteres.',
            'password.min' => 'Este campo debe contener al menos 6 caracteres.',
            'password_confirmation.max' => 'Este campo debe contener máximo 20 caracteres.',
            'password_confirmation.min' => 'Este campo debe contener al menos 6 caracteres.',
            'password_confirmation.same' => 'Las contraseñas que ingresaste no coinciden.',
        ];

        $rules = [
            'password' => 'required|min:6|max:20',
            'password_confirmation' => 'same:password|min:6|max:20',
        ];

        $validator = \Validator::make($data, $rules, $messages);
        return $validator;
    }

}
