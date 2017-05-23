<?php

namespace WsAmigox\Util;

use Firebase\JWT\JWT;
use WsAmigox\Configuration\Configuration;

class JWTAuth
{
    /**
     * Informa o algoritmo usado para a criptografia
     */
    // const ALGORITHM = "HS256";
    /**
     * Chave para realizar a descriptografia. Foi gerada usando o comando openssl rand 64 | base64
     */
    const CHAVE_JWT = 'cJRJ1slFUJhsN1worFmPaCxLAPxgIQdi4yIXQKlv4UTo0urdWLr3iHjaAgWH1dbBNRgBhRkDfMXY5v5xUIsi/w==';

    /**
     * Codifica o array usando o padrao JWT
     * @param  array  $arrayToken array com os dados a serem criptografados
     * @return string             string codificada pelo JWT
     */
    public static function encode(array $arrayToken)
    {
        // return JWT::encode($arrayToken, self::CHAVE_JWT, self::ALGORITHM);
        return JWT::encode($arrayToken, Configuration::read('authentication')['jwtKey'], Configuration::read('authentication')['algorithm']);
    }
}
