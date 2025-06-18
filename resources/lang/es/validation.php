<?php

return [

    'required' => ':attribute es obligatorio.',
    'unique' => 'El valor de :attribute ya está en uso.',
    'numeric' => ':attribute debe ser un número.',
    'integer' => ':attribute debe ser un número entero.',
    'min' => [
        'string' => ':attribute debe tener al menos :min caracteres.',
    ],
    'max' => [
        'string' => ':attribute debe tener al menos :max caracteres.',
    ],

    'attributes' => [
        'codigo' => 'Código',
        'nombre' => 'Nombre del producto',
        'descripcion' => 'Descripción',
        'cantidad' => 'Cantidad',
        'precio_unitario' => 'Precio unitario',
    ],

];
