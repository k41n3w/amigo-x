<?php

namespace Util;

use Firebase\JWT\JWT;
use Psr\Http\Message\ServerRequestInterface as Request;
use Configuration\Configuration;

class JWTAuth
{
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
