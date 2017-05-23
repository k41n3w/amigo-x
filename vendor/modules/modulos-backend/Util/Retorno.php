<?php

namespace Util;

final class Retorno
{
    private static function retorno($intCodigo, $mxdRetorno)
    {
        return [
            "codigo" => $intCodigo,
            "retorno" => $mxdRetorno
        ];
    }

    public static function sucesso($mxdRetorno)
    {
        return self::retorno(1, $mxdRetorno);
    }

    public static function erro($mxdRetorno)
    {
        return self::retorno(0, $mxdRetorno);
    }

    public static function outro($mxdRetorno, $intCodigo = 2)
    {
        return self::retorno($intCodigo, $mxdRetorno);
    }
}
