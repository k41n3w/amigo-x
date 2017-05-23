<?php

return [
    'authentication' => [
        'jwtKey' => 'cJRJ1slFUJhsN1worFmPaCxLAPxgIQdi4yIXQKlv4UTo0urdWLr3iHjaAgWH1dbBNRgBhRkDfMXY5v5xUIsi/w==',
        'algorithm' => 'HS256'
    ],
    'databases' => [
        'mysql' => [
            'database' => 'mysql',
            'host' => '192.168.113.86',
            'port' => '3306',
            'dbname' => 'amigo_x',
            'user' => 'root',
            'password' => 'root',
            'charset' => 'utf8'
        ]
    ],
    'diretoriobase' => dirname(dirname(__DIR__)),
    'diretorioanexo' => 'arquivos',
    'tiposarquivospermitidos' => [
        'application/pdf',
        'image/png',
        'image/jpeg'
    ]
];
