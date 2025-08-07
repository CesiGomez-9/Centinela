<?php

return [
    'required' => ':attribute es obligatorio.',
    'unique' => ':attribute ya está en uso.',
    'numeric' => ':attribute debe ser un número.',
    'integer' => ':attribute debe ser un número entero.',
    'min' => [
        'string' => ':attribute debe tener al menos :min caracteres.',
    ],
    'max' => [
        'string' => ':attribute debe tener al menos :max caracteres.',
    ],
    'size' => [
        'string' => 'El campo :attribute debe tener exactamente :size dígitos.',
    ],

    'attributes' => [
        'serie' => 'Serie',
        'codigo' => 'Código',
        'nombre' => 'Nombre del producto',
        'marca' => 'Marca del producto',
        'modelo' => 'Modelo del producto',
        'categoria' => 'Categoria del producto',
        'es_exento' => 'IVA del producto',
        'descripcion' => 'Descripción',
        'numero_factura' => 'Numero de factura',
        'fecha' => 'Fecha',
        'proveedor' => 'Proveedor',
        'forma_pago' => 'Forma de pago',
        'responsable' => 'Responsable',
        'observaciones' => 'Observaciones',
    ],
];
