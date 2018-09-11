<?php
/**
 * Created by PhpStorm.
 * User: vroldan
 * Date: 9/21/16
 * Time: 11:01 AM
 */

namespace App\Validations;


/**
 * Class RentalAgencyValidations
 * @package App\Models\Validations
 */
/**
 * Class RentalAgencyValidations
 * @package App\Validations
 */
class RentalAgencyValidations
{

    /**
     * @param $data
     * @return mixed
     */
    static function registerValidation($data)
    {
        $messages = array(
            'name.required' => 'Este campo no puede estar vacío',
            'name.max' => 'Este campo no puede tener mas de 40 caracteres',
            'address.required' => 'Este campo no puede estar vacío',
            'address.max' => 'Este campo no puede tener mas de 100 caracteres',
            'phone.required' => 'Este campo no puede estar vacío',
            'phone.regex' => 'El número de teléfono debe introducirse en el siguiente formato: (Ejm: +18131234567)',
            'phone.between' => 'Debe ingresar un número telefónico válido',
        );

        $rules = array(
            'name'=>'required|max:40',
            'address' => 'required|max:100',
            'phone' => 'required|regex:/^\+?\d+$/|between:10,14',
        );
        
        $validator = \Validator::make($data, $rules, $messages);
        return $validator;
    }

    /**
     * @param $data
     * @return mixed
     */
    static function updateRegisterValidation($data)
    {
        $messages = [
            'name.required' => 'Este campo no puede estar vacío',
            'name.max' => 'Este campo no puede tener mas de 255 caracteres',
            'address.required' => 'Este campo no puede estar vacío',
            'address.max' => 'Este campo no puede tener mas de 255 caracteres',
            'phone.required' => 'Este campo no puede estar vacío',
            'phone.regex' => 'Debe ingresar un número telefónico válido. (Ejm: 04141234567 / +584141234567)',
            'phone.between' => 'Debe ingresar un número telefónico válido',
            'description.required' => 'Este campo no puede estar vacío',
        ];

        $rules = [
            'name'=>'required|max:255',
            'address' => 'required|max:255',
            'phone' => 'required|regex:/^\+?\d+$/|between:10,14',
            'description' => 'required',
        ];

        $validator = \Validator::make($data, $rules, $messages);
        return $validator;
    }

    /**
     * @param $data
     * @return mixed
     */
    static function registerAdminRentalValidation($data)
    {
        $messages = [
            'name.regex' => 'No puede colocar caracteres especiales o números',
            'name.required' => 'Este campo no puede estar vacío',
            'name.max' => 'Este campo no puede tener mas de 40 caracteres',
            'email.required' => 'Este campo no puede estar vacío',
            'email.regex' => 'Este campo no cumple con el formato de una direccion de correo valida',
            'email.email' => 'Este campo no tiene una direccion de correo valida',
            'email.unique' => 'Este email ya existe en nuestra base de datos',
            'address.required' => 'Este campo no puede estar vacío',
            'address.max' => 'Este campo no puede tener mas de 100 caracteres',
            'phone.required' => 'Este campo no puede estar vacío',
            'phone.regex' => 'Debe ingresar un número telefónico válido. (Ejm: 04141234567 / +584141234567)',
            'phone.between' => 'Debe ingresar un número telefónico válido',
            'agency_id.required' => 'Debe seleccionar una agencia',
        ];

        $rules = [
            'name'=>'regex:/^[A-Za-zñÑáéíóú\s]+$/|required|max:40',
            'email' => 'required|email|unique:users',
            'address' => 'required|max:100',
            'phone' => 'required|regex:/^\+?\d+$/|between:10,14',
            'agency_id' => 'required|integer',
        ];
        if($data['roleOption']==1){
            unset($rules['agency_id']);
        }

        $validator = \Validator::make($data, $rules, $messages);
        return $validator;
    }

    /**
     * Validación para el Admin de una Agencia
     * @param $data
     * @param $id
     * @return mixed
     */
    static function updatedUserAdminRentalValidation($data,$id)
    {
        $messages = [
            'name.regex' => 'No puede colocar caracteres especiales o números',
            'name.required' => 'Este campo no puede estar vacío',
            'name.max' => 'Este campo no puede tener mas de 40 caracteres',
            'email.required' => 'Este campo no puede estar vacío',
            'email.email' => 'Este campo no tiene una direccion de correo valida',
            'email.unique' => 'Este email ya existe en nuestra base de datos',
            'address.required' => 'Este campo no puede estar vacío',
            'address.max' => 'Este campo no puede tener mas de 100 caracteres',
            'phone.required' => 'Este campo no puede estar vacío',
            'phone.regex' => 'Debe ingresar un número telefónico válido. (Ejm: 04141234567 / +584141234567)',
            'phone.between' => 'Debe ingresar un número telefónico válido',
        ];

        $rules = [
            'name'=>'regex:/^[A-Za-zñÑáéíóú\s]+$/|required|max:40',
            'email' => 'required|email|unique:users,email,'.$id,
            'address' => 'required|max:100',
            'phone' => 'required|regex:/^\+?\d+$/|between:10,14',
        ];

        $validator = \Validator::make($data, $rules, $messages);
        return $validator;
    }

    /**
     * @param $data
     * @return mixed
     */
    static function updatedAdminRentalValidation($data)
    {
        $messages = [
            'name.required' => 'Este campo no puede estar vacío',
            'name.max' => 'Este campo no puede tener mas de 40 caracteres',
            'address.required' => 'Este campo no puede estar vacío',
            'address.max' => 'Este campo no puede tener mas de 100 caracteres',
            'description.max' => 'Este campo no puede tener mas de 255 caracteres',
            'phone.required' => 'Este campo no puede estar vacío',
            'phone.regex' => 'Debe ingresar un número telefónico válido. (Ejm: 04141234567 / +584141234567)',
            'phone.between' => 'Debe ingresar un número telefónico válido',
        ];

        $rules = [
            'name'=>'required|max:40',
            'address' => 'required|max:100',
            'description' => 'max:255',
            'phone' => 'required|regex:/^\+?\d+$/|between:10,14',
        ];

        $validator = \Validator::make($data, $rules, $messages);
        return $validator;
    }

    /**
     * @param $data
     * @return mixed
     */
    static function disableAdminRentalValidation($data)
    {
        $rules = [
            'id'    =>'required|integer',
        ];
        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    static function registerAgent($data)
    {
        $messages = array(
            'name.required' => 'Este campo no puede estar vacío',
            'name.max' => 'Este campo no puede tener mas de 40 caracteres',
            'email.required' => 'Este campo no puede estar vacío',
            'email.email' => 'Este campo no tiene una direccion de correo valida',
            'email.unique' => 'Este email ya existe en nuestra base de datos',
            'address.max' => 'Este campo no puede tener mas de 100 caracteres',
            'phone.required' => 'Este campo no puede estar vacío',
            'phone.regex' => 'Debe ingresar un número telefónico válido. (Ejm: 04141234567 / +584141234567)',
            'phone.between' => 'Debe ingresar un número telefónico válido',
        );

        $rules = array(
            'name'=>'required|max:40',
            'email' => 'required|email|unique:users',
            'address' => 'max:100',
            'phone' => 'required|regex:/^\+?\d+$/|between:10,14',
        );

        $validator = \Validator::make($data, $rules, $messages);
        return $validator;
    }

    /**
     * Validación para el Agente de una Agencia
     * @param $data
     * @param $id
     * @return mixed
     */
    static function updatedAgent($data,$id)
    {
        $messages = [
            'name.required' => 'Este campo no puede estar vacío',
            'name.max' => 'Este campo no puede tener mas de 40 caracteres',
            'email.required' => 'Este campo no puede estar vacío',
            'email.email' => 'Este campo no tiene una direccion de correo valida',
            'email.unique' => 'Este email ya existe en nuestra base de datos',
            'address.max' => 'Este campo no puede tener mas de 100 caracteres',
            'phone.required' => 'Este campo no puede estar vacío',
            'phone.regex' => 'Debe ingresar un número telefónico válido. (Ejm: 04141234567 / +584141234567)',
            'phone.between' => 'Debe ingresar un número telefónico válido',
        ];

        $rules = [
            'name'=>'required|max:40',
            'email' => 'required|email|unique:users,email,'.$id,
            'address' => 'max:100',
            'phone' => 'required|regex:/^\+?\d+$/|between:10,14',
        ];

        $validator = \Validator::make($data, $rules, $messages);
        return $validator;
    }

}
