<?php

return [
    'required' => 'El campo :attribute es obligatorio.',
    'unique' => 'El valor de :attribute ya está en uso.',
    'max' => [
        'string' => 'El campo :attribute no puede tener más de :max caracteres.',
    ],
    'min' => [
        'string' => 'El campo :attribute debe tener al menos :min caracteres.',
        'numeric' => 'El campo :attribute debe ser al menos :min.',
    ],
    'numeric' => 'El campo :attribute debe ser un número.',
    'integer' => 'El campo :attribute debe ser un número entero.',

    'attributes' => [
        'codigo' => 'código',
        'nombre' => 'nombre del producto',
        'descripcion' => 'descripción',
        'cantidad' => 'cantidad',
        'precio_unitario' => 'precio unitario',
    ],
];
