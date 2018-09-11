<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'El campo :attribute debe ser aceptado.',
    'active_url'           => 'El campo :attribute no es una URL valida.',
    'after'                => 'El campo :attribute debe ser una fecha posterior a la :date.',
    'alpha'                => 'El campo :attribute solo puede contener letras.',
    'alpha_dash'           => 'El campo :attribute sólo puede contener letras, números y guiones.',
    'alpha_num'            => 'El campo :attribute solo puede contener letras y números.',
    'array'                => 'El campo :attribute debe ser una matriz.',
    'before'               => 'El campo :attribute debe ser una fecha antes a la :date.',
    'between'              => [
        'numeric'          => 'El campo :attribute debe estar entre :min y:max.',
        'file'             => 'El campo :attribute debe estar entre :min y :max kilobytes.',
        'string'           => 'El campo :attribute debe estar entre :min y :max caracteres.',
        'array'            => 'El campo :attribute debe estar entre :min and :max items.',
    ],
    'boolean'              => 'El campo :attribute debe ser verdadero o falso.',
    'confirmed'            => 'El campo :attribute de confirmación no coincide.',
    'date'                 => 'El campo :attribute no es una fecha valida',
    "date_format"          => ":attribute no coincide con el formato :format.",
    "different"            => ":attribute y :other deben ser diferente.",
    "digits"               => ":attribute debe tener :digits dígitos.",
    'digits_between'       => 'El campo :attribute debe ser entre :min y :max dígitos.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => ':attribute tiene un valor duplicado.',
    'email'                => 'El campo :attribute no es una dirección de correo valida',
    "exists"               => ":attribute es inválido.",
    'filled'               => ':attribute es requerido.',
    "image"                => ":attribute debe ser una imagen.",
    "in"                   => ":attribute es inválido.",
    'in_array'             => ':attribute no existe en :other.',
    "integer"              => ":attribute debe ser un entero.",
    "ip"                   => ":attribute debe ser una dirección IP válida.",
    'json'                 => ':attribute debe ser una cadena JSON válida.',
    'file'                 => ':attribute debe ser un archivo.',
    'max'                  => [
        'numeric'          => 'El campo :attribute no puede ser mayor a :max números.',
        "file"             => ":attribute no puede ser mayor a :max kilobytes.",
        'string'           => 'El campo :attribute no puede ser mayor a :max caracteres.',
        "array"            => ":attribute no puede tener mas de :max elementos.",
    ],
    "mimes"                => ":attribute debe ser un archivo de tipo: :values.",
    'mimetypes'            => ':attribute debe ser un archivo de tipo: :values.',
    'min'                  => [
        "numeric"          => ":attribute debe ser al menos :min.",
        "file"             => ":attribute debe tener al menos :min kilobytes.",
        "string"           => ":attribute debe tener al menos :min carácteres.",
        "array"            => ":attribute debe tener al menos :min elementos.",
    ],
    "not_in"               => ":attribute seleccionado es inválido.",
    "numeric"              => ":attribute debe ser un número.",
    'present'              => ':attribute debe estar presente.',
    "regex"                => "El formato :attribute es inválido.",
    'required'             => 'El campo :attribute no puede estar vacío.',
    "required_if"          => ":attribute es necesario cuando :other es :value.",
    'required_unless'      => ':attribute es necesario a no ser que :other esté en :values.',
    "required_with"        => ":attribute es necesario cuando :values está presente.",
    "required_with_all"    => ":attribute es necesario cuando :values están presentes.",
    "required_without"     => ":attribute es necesario cuando :values no está presente.",
    "required_without_all" => ":attribute es necesario cuando :values no estan presentes.",
    "same"                 => ":attribute y :other deben coincidir.",
    'size'                 => [
        "numeric"          => ":attribute debe ser :size.",
        "file"             => ":attribute debe ser :size kilobytes.",
        "string"           => ":attribute debe ser :size carácteres.",
        "array"            => ":attribute debe contener :size elementos.",
    ],
    'string'               => ':attribute debe ser una cadena de carácteres.',
    'timezone'             => ':attribute debe ser una zona válida.',
    "unique"               => ":attribute ya ha sido elegido.",
    'uploaded'             => ':attribute no se pudo subir.',
    "url"                  => "El formato :attribute es inválido.",

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */
    "older_than"           => "Edad no válida.",
    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
        'code' => [
            'exists' => 'Cupón Invalido',
        ],
        'email' => [
            'unique' => 'Este correo ya existe en uPPyx. Puedes ir a la pantalla inicial y recuperar tu contraseña.',
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
