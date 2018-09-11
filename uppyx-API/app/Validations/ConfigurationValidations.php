<?php

namespace App\Validations;


/**
 * Class ConfigurationValidations
 * @package App\Models\Validations
 */
/**
 * Class ConfigurationValidations
 * @package App\Validations
 */
class ConfigurationValidations
{
    /**
     * Validación para Configuraciones
     * @param $data
     * @param $id
     * @return mixed
     */
    static function updatedConfigurationValidation($data,$id)
    {
        $messages = [
            'alias.required' => 'Este campo no puede estar vacío',
            'name.required' => 'Este campo no puede estar vacío',
            'name.max' => 'Este campo no puede tener mas de 50 caracteres',
            'name_en.required' => 'Este campo no puede estar vacío',
            'name_en.max' => 'Este campo no puede tener mas de 50 caracteres',
            'value.required' => 'Este campo no puede estar vacío',
            //'country_id.required' => 'Este campo no puede estar vacío',
            //'city_id.required' => 'Este campo no puede estar vacío',
            //'type.required' => 'Este campo no puede estar vacío',
        ];

        $rules = [
            'alias'=>'required',
            'name'=>'required|max:100',
            'name_en'=>'required|max:100',
            'value' => 'required',
            //'country_id' => 'required',
            //'city_id' => 'required',
            //'type' => 'required',
        ];

        $validator = \Validator::make($data, $rules, $messages);
        return $validator;
    }
}