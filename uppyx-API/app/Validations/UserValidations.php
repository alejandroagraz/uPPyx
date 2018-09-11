<?php
/**
 * Created by PhpStorm.
 * User: vroldan
 * Date: 9/21/16
 * Time: 11:01 AM
 */

namespace App\Validations;


/**
 * Class UserValidations
 * @package App\Models\Validations
 */
/**
 * Class UserValidations
 * @package App\Validations
 */
class UserValidations
{

    /**
     * @param $data
     * @return mixed
     */
    public static function signUpValidation($data)
    {
        $rules = [
            'name'                  => 'required|max:255',
            'email'                 => 'required|email|max:255|unique:users',
            'password'              => 'required|min:6|confirmed',
            'password_confirmation' => 'required_with:password|min:6|max:20',
            'lang'                  => 'required|in:en,es',
            'token_device'          => 'required',
            'operative_system'      => 'required|in:ios,android',
            'phone'                 => 'regex:/^\+?\d+$/|min:9|max:14',
            'country'               => 'required|string|max:255',
            'city'                  => 'string|max:255',
            'gender'                => 'in:F,M',
            'birth_of_date'         => 'required|date_format:Y-m-d|older_than:25',
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function resendEmailConfirmationValidation($data)
    {
        $rules = [
            'lang'  => 'required|in:en,es',
            'email' => 'required|max:255|email',
        ];
        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function updateUserValidation($data)
    {
        $rules = [
            'lang'          => 'required|in:en,es',
            'phone'         => 'regex:/^\+?\d+$/|min:9|max:14',
            'name'          => 'required|max:255',
            'birth_of_date' => 'date_format:Y-m-d|older_than:25',
            'country'       => 'string|max:255',
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function loginValidation($data){
        $rules = [];
        $rules['lang']              = 'required|in:en,es';
        $rules['username']          = 'required|email';
        $rules['password']          = 'required';
        $rules['token_device']      = 'required';
        $rules['operative_system']  = 'required|in:ios,android';

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function loginSocialValidation($data){
        $rules = [];
        $rules['lang']              = 'required|in:en,es';
        $rules['social_id']         = 'required|string';
        $rules['social_token']      = 'required|string';
        $rules['email']             = 'required|email';
        $rules['operative_system']  = 'required|in:ios,android';
        $rules['provider']          = 'required|in:facebook,google';
        $rules['phone']             = 'regex:/^\+?\d+$/|min:9|max:14';
        $rules['country']           = 'string|max:255';
        $rules['city']              = 'string|max:255';
        $rules['gender']            = 'in:F,M';
        $rules['birth_of_date']     = 'required|date_format:Y-m-d|older_than:25';
        $rules['avatar']            = 'string';

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function logoutValidation($data){
        $rules = [];
        $rules['lang']              = 'required|in:en,es';
        $rules['user_id']           = 'required|exists:users,uuid,deleted_at,NULL';
        $rules['token_device']      = 'required';

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function changePasswordUserValidation($data){
        $rules = [
            'lang'                      => 'required|in:en,es',
            'user_id'                   => 'required|exists:users,uuid,deleted_at,NULL',
            'password'                  => 'required|confirmed|min:5|max:15|regex:/^(?=.*\d).+$/',
            'password_confirmation'     => 'required_with:password|min:5|regex:/^(?=.*\d).+$/'
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function getUserNotificationsValidation($data){
        $rules = [
            'lang' => 'required|in:en,es',
            'user_id' => 'required|exists:users,uuid,deleted_at,NULL'
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function uploadProfilePictureValidation($data)
    {
        $rules = [
            'lang'              => 'required|in:en,es',
            'image'             => 'image|required',
            'user_id'           => 'required|exists:users,uuid,deleted_at,NULL',
            'picture_profile'   => 'required|in:true,false',
        ];
        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function uploadUserLicenseValidation($data)
    {
        $rules = [
            'lang'              => 'required|in:en,es',
            'image'             => 'image|required',
            'user_id'           => 'required|exists:users,uuid,deleted_at,NULL',
            'picture_profile'   => 'required|in:true,false',
        ];
        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    /**
     * @param $data
     * @return $validator
     */
    public static function changePasswordValidation($data)
    {
        $rules = [
            'lang'                      => 'required|in:en,es',
            'user_id'                   => 'required|exists:users,uuid,deleted_at,NULL',
            'password'                  => 'required|confirmed|min:5|max:15|regex:/^(?=.*\d).+$/',
            'password_confirmation'     => 'required_with:password|min:5|regex:/^(?=.*\d).+$/'
        ];
        $validator = \Validator::make($data, $rules);
        return $validator;
    }


    /**
     * @param $data
     * @return mixed
     */
    public static function getUserValidation($data){
        $rules = [
            'lang' => 'required|in:en,es',
            'user_id' => 'required|exists:users,uuid,deleted_at,NULL'
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function getUserByFieldValidation($data){
        $rules = [
            'lang' => 'required|in:en,es',
            'column' => 'required|in:email,facebook_id,google_id',
            'value' => 'required|string'
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function getUserLoginValidation($data){
        $messages = array(
            'email.required' => 'Este campo no puede estar vacío',
            'email.email' => 'El formato de email no es correcto',
            'password.required' => 'Este campo no puede estar vacío',
            'password.min' => 'Su clave debe contener al menos 6 caracteres',
        );

        $rules = array(
            'email' => 'required|email',
            'password' => 'required|min:6',
        );

        $validator = \Validator::make($data, $rules, $messages);
        return $validator;
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function imageProfileValidation($data){
        $messages = array(
            'picture.max' => 'La imagen sobrepasa el tamaño máximo permitido (2MB).',
            'picture.mime' => 'La extensión del archivo no es válida.',
            'picture.image' => 'El archivo seleccionado debe ser una imagen.',
        );

        $rules = array(
            'picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        );

        $validator = \Validator::make($data->toArray(), $rules, $messages);
        return $validator;
    }
}
