<?php

namespace Connection;

use PDO;
use Connection\Database;
use Configuration\Configuration;

final class ConnectionFactory
{
    private $connection;

    /**
     * Realiza a conexao com o banco de dados no construtor
     * @param string $strNameConnection nome da conexao a ser usada
     */
    public function __construct(string $strNameConnection)
    {
        $arrayDatabases = Configuration::read('databases');
        $this->connect($arrayDatabases[$strNameConnection]);
    }

    /**
     * Retorna a conexao realizada
     * @return PDO a instancia da classe PDO com a conexao
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Faz a conexao com a base de dados
     * @param  array  $arrayConfig array com as configuracoes da conexao
     * @return void
     */
    private function connect(array $arrayConfig)
    {
        try {
            $options = [
              PDO::ATTR_PERSISTENT => true
            ];
            $dsn = $this->getDsn($arrayConfig);
            $this->connection = new PDO($dsn, $arrayConfig['user'], $arrayConfig['password'], $options);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Houve um erro: '.$e->getMessage();
            exit;
        }
    }

    /**
     * Gera o DSN (Data Source Name) de acordo com o banco de dados
     * @param  array  $arrayConfig array com as configuracoes da conexao
     * @return string retorna uma string com o dsn gerado
     * @throws ConnectionNotFoundException caso nao encontre a conexao
     */
    private function getDsn(array $arrayConfig)
    {
        if ($arrayConfig['database'] === Database::MYSQL) {
            $dsn = 'mysql:host='.$arrayConfig['host'].';';
            $dsn.= 'port='.$arrayConfig['port'].';';
            $dsn.= 'dbname='.$arrayConfig['dbname'].';';
            $dsn.= 'charset='.$arrayConfig['charset'].';';
        } elseif ($arrayConfig['database'] === Database::FIREBIRD) {
            $dsn = 'firebird:dbname='.$arrayConfig['host'].':'.$arrayConfig['dbname'].';';
            $dsn.= 'charset='.$arrayConfig['charset'].';';
        } elseif ($arrayConfig['database'] === Database::POSTGRESQL) {
            $dsn = 'pgsql:host='.$arrayConfig['host'].';';
            $dsn.= 'port='.$arrayConfig['port'].';';
            $dsn.= 'dbname='.$arrayConfig['dbname'].';';
            $dsn.= 'charset='.$arrayConfig['charset'].';';
        } else {
            throw new ConnectionNotFoundException('Conexão não encontrada');
        }
        return $dsn;
    }
}
