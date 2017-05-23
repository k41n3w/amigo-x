<?php

namespace Configuration;

use Exception\ConfigurationNotFoundException;

final class Configuration
{
    private static $arrayConfigurations = [];

    /**
     * Carrega as configuracoes do aplicativo
     * @return void
     */
    private static function loadConfig()
    {
        $strPath = dirname(dirname(dirname(dirname(__DIR__))));
        self::$arrayConfigurations = require $strPath.'/api/config/config.php';
    }

    /**
     * Recupera uma configuracao do aplicativo
     * @param  string $key nome da configuracao que deseja
     * @return array retorna um array com as configuracoes
     * @throws ConfigurationNotFoundException caso a configuracao nao exista
     */
    public static function read(string $key)
    {
        self::loadConfig();
        if (array_key_exists($key, self::$arrayConfigurations)) {
            return self::$arrayConfigurations[$key];
        } else {
            throw new ConfigurationNotFoundException('Configuração não encontrada!');
        }
    }
}
