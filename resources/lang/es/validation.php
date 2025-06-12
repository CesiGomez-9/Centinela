<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Mensajes de Validación
    |--------------------------------------------------------------------------
    |
    | Aquí están los mensajes predeterminados de validación en español.
    | Puedes personalizarlos según tus necesidades.
    |
    */

    'accepted'             => 'El atributo :attribute debe ser aceptado.',
    'active_url'           => 'El atributo :attribute no es una URL válida.',
    'after'                => 'El atributo :attribute debe ser una fecha posterior a :date.',
    'after_or_equal'       => 'El atributo :attribute debe ser una fecha posterior o igual a :date.',
    'alpha'                => 'El atributo :attribute solo debe contener letras.',
    'alpha_dash'           => 'El atributo :attribute solo debe contener letras, números, guiones y guiones bajos.',
    'alpha_num'            => 'El atributo :attribute solo debe contener letras y números.',
    'array'                => 'El atributo :attribute debe ser un arreglo.',
    'before'               => 'El atributo :attribute debe ser una fecha anterior a :date.',
    'before_or_equal'      => 'El atributo :attribute debe ser una fecha anterior o igual a :date.',
    'between'              => [
        'numeric' => 'El atributo :attribute debe estar entre :min y :max.',
        'file'    => 'El archivo :attribute debe pesar entre :min y :max kilobytes.',
        'string'  => 'El atributo :attribute debe contener entre :min y :max caracteres.',
        'array'   => 'El atributo :attribute debe tener entre :min y :max elementos.',
    ],
    'boolean'              => 'El atributo :attribute debe ser verdadero o falso.',
    'confirmed'            => 'La confirmación de :attribute no coincide.',
    'date'                 => 'El atributo :attribute no es una fecha válida.',
    'date_equals'          => 'El atributo :attribute debe ser una fecha igual a :date.',
    'date_format'          => 'El atributo :attribute no coincide con el formato :format.',
    'different'            => 'Los campos :attribute y :other deben ser diferentes.',
    'digits'               => 'El atributo :attribute debe tener :digits dígitos.',
    'digits_between'       => 'El atributo:attribute debe tener entre :min y :max dígitos.',
    'dimensions'           => 'El atributo :attribute tiene dimensiones de imagen inválidas.',
    'distinct'             => 'El atributo :attribute tiene un valor duplicado.',
    'email'                => 'El atributo :attribute debe ser un correo electrónico válido.',
    'ends_with'            => 'El atributo :attribute debe finalizar con uno de los siguientes valores: :values.',
    'exists'               => 'El atributo :attribute seleccionado no es válido.',
    'file'                 => 'El atributo:attribute debe ser un archivo.',
    'filled'               => 'El atributo :attribute debe tener un valor.',
    'gt'                   => [
        'numeric' => 'El atributo :attribute debe ser mayor que :value.',
        'file'    => 'El archivo :attribute debe pesar más de :value kilobytes.',
        'string'  => 'El atributo :attribute debe tener más de :value caracteres.',
        'array'   => 'El atributo :attribute debe tener más de :value elementos.',
    ],
    'gte'                  => [
        'numeric' => 'El atributo :attribute debe ser mayor o igual que :value.',
        'file'    => 'El archivo :attribute debe pesar al menos :value kilobytes.',
        'string'  => 'El atributo :attribute debe tener al menos :value caracteres.',
        'array'   => 'El atributo:attribute debe tener al menos :value elementos.',
    ],
    'image'                => 'El atributo :attribute debe ser una imagen.',
    'in'                   => 'El atributo :attribute seleccionado no es válido.',
    'in_array'             => 'El atributo :attribute no existe en :other.',
    'integer'              => 'El atributo :attribute debe ser un número entero.',
    'ip'                   => 'El atributo:attribute debe ser una dirección IP válida.',
    'ipv4'                 => 'El atributo :attribute debe ser una dirección IPv4 válida.',
    'ipv6'                 => 'El atributo :attribute debe ser una dirección IPv6 válida.',
    'json'                 => 'El atributo :attribute debe ser una cadena JSON válida.',
    'lt'                   => [
        'numeric' => 'El atributo :attribute debe ser menor que :value.',
        'file'    => 'El archivo :attribute debe pesar menos de :value kilobytes.',
        'string'  => 'El atributo :attribute debe tener menos de :value caracteres.',
        'array'   => 'El atributo :attribute debe tener menos de :value elementos.',
    ],
    'lte'                  => [
        'numeric' => 'El atributo :attribute debe ser menor o igual que :value.',
        'file'    => 'El archivo :attribute debe pesar como máximo :value kilobytes.',
        'string'  => 'El atributo :attribute debe tener como máximo :value caracteres.',
        'array'   => 'El atributo :attribute no debe tener más de :value elementos.',
    ],
    'max'                  => [
        'numeric' => 'El atributo :attribute no debe ser mayor que :max.',
        'file'    => 'El archivo :attribute no debe pesar más de :max kilobytes.',
        'string'  => 'El atributo:attribute no debe tener más de :max caracteres.',
        'array'   => 'El atributo :attribute no debe tener más de :max elementos.',
    ],
    'mimes'                => 'El campo :attribute debe ser un archivo de tipo: :values.',
    'mimetypes'            => 'El campo :attribute debe ser un archivo de tipo: :values.',
    'min'                  => [
        'numeric' => 'El atributo :attribute debe ser al menos :min.',
        'file'    => 'El archivo :attribute debe pesar al menos :min kilobytes.',
        'string'  => 'El atributo :attribute debe tener al menos :min caracteres.',
        'array'   => 'El atributo :attribute debe tener al menos :min elementos.',
    ],
    'not_in'               => 'El atributo :attribute seleccionado no es válido.',
    'not_regex'            => 'El formato del atributo :attribute no es válido.',
    'numeric'              => 'El atributo :attribute debe ser un número.',
    'present'              => 'El atributo :attribute debe estar presente.',
    'regex'                => 'El formato del atributo :attribute no es válido.',
    'required'             => 'El atributo :attribute es obligatorio.',
    'required_if'          => 'El atributo :attribute es obligatorio cuando :other es :value.',
    'required_unless'      => 'El campo :attribute es obligatorio a menos que :other esté en :values.',
    'required_with'        => 'El campo :attribute es obligatorio cuando :values está presente.',
    'required_with_all'    => 'El campo :attribute es obligatorio cuando :values están presentes.',
    'required_without'     => 'El campo :attribute es obligatorio cuando :values no está presente.',
    'required_without_all' => 'El campo :attribute es obligatorio cuando ninguno de :values está presente.',
    'same'                 => 'Los campos :attribute y :other deben coincidir.',
    'size'                 => [
        'numeric' => 'El campo :attribute debe ser :size.',
        'file'    => 'El archivo :attribute debe pesar :size kilobytes.',
        'string'  => 'El atributo :attribute debe tener :size caracteres.',
        'array'   => 'El campo :attribute debe contener :size elementos.',
    ],
    'starts_with'          => 'El atributo :attribute debe comenzar con uno de los siguientes: :values.',
    'string'               => 'El atributo :attribute debe ser una cadena de texto.',
    'timezone'             => 'El campo :attribute debe ser una zona horaria válida.',
    'unique'               => 'El campo :attribute ya está en uso.',
    'uploaded'             => 'El campo :attribute falló al subir.',
    'url'                  => 'El formato del atributo :attribute no es válido.',

    /*
    |--------------------------------------------------------------------------
    | Atributos Personalizados
    |--------------------------------------------------------------------------
    |
    | Aquí puedes definir nombres más amigables para los atributos, para que
    | en los mensajes de error aparezca algo más legible para el usuario.
    |
    */

    'attributes' => [
        'nombreEmpresa'       => 'nombre de la empresa',
        'direccion'           => 'dirección',
        'telefonodeempresa'   => 'teléfono de la empresa',
        'correoempresa'       => 'correo electrónico',
        'nombrerepresentante' => 'nombre del representante',
        'identificacion'      => 'identificación',
        'categoriarubro'      => 'categoría o rubro',
    ],

];
