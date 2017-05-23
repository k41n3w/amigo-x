<?php

namespace Model;

use PDO;
use Connection\ConnectionFactory;

abstract class AppModel
{
    private $connection;

    /**
     * Construtor da classe que estabele a conexao a ser usada
     * @param string $strNameConnection nome da conexao
     */
    public function __construct($strNameConnection = 'mysql')
    {
        $this->setConnection($strNameConnection);
    }

    /**
     * Metodo que faz a conexao com o banco de dados
     * @param string $strNameConnection nome da conexao a ser usada
     */
    public function setConnection(string $strNameConnection)
    {
        $objConnectionFactory = new ConnectionFactory($strNameConnection);
        $this->connection = $objConnectionFactory->getConnection();
    }

    /**
     * Metodo que recupera a conexao com o banco de dados.
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Metodo que realiza uma operacao ao banco de dados
     * @param  string $sql             instrucao SQL a ser realizada
     * @param  array $arrayParameters  array com os parametros da consulta (opcional)
     * @return PDOStatement            retorna um objeto da classe PDOStatement
     */
    public function execute(string $sql, $arrayParameters = null)
    {
        try {
            $statement = $this->connection->prepare($sql);
            if (is_null($arrayParameters)) {
                $statement->execute();
            } else {
                $statement->execute($arrayParameters);
            }
            return $statement;
        } catch (PDOException $e) {
            echo 'Ocorreu um erro ao executar a consulta. Erro: '.$e->getMessage();
            exit;
        }
    }

    /**
    * [executeSQL executa uma instrução SELECT no banco com parametros]
    * @param  string $sql        [string com a consulta a ser feita]
    * @param  array  $parameters [array com os parãmetros da consulta]
    * @return mixed              [retorna um array associativo ou false]
    *                            [caso a consulta retorne vazio]
    */
    public function executeSQL(string $sql, array $parameters) {
        try {
            $this->connection->beginTransaction();
            $statement = $this->connection->prepare($sql);
            $statement->execute($parameters);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            if (count($result) > 0) {
                $this->connection->commit();
                return $result;
            }
            $this->connection->commit();
            return false;
        } catch (PDOException $e) {
            $this->connection->rollBack();
            echo 'Ocorreu um erro ao executar a consulta: '.$e->getMessage();
            exit;
        }

    }

    /**
     * Metodo que realiza uma consulta do tipo SELECT no banco de dados
     * @param  string $sql             instrucao SQL a ser realizada
     * @param  array $arrayParameters  array com os parametros da consulta (opcional)
     * @return array                   retorna um array associativo com os dados da consulta
     *                                 ou false caso a consulta nao retorne nada
     */
    public function select(string $sql, $arrayParameters = null)
    {
        if (!empty($arrayParameters)) {
            foreach ($arrayParameters as $key => $value) {
                if (is_null($value)) {
                    unset($arrayParameters[$key]);
                }
            }
        }
        $statement = $this->execute($sql, $arrayParameters);
        $arrayResult = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($arrayResult) > 0) {
            return $arrayResult;
        }
        return false;
    }

}
