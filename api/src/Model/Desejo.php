<?php

namespace Model;

use PDO;
use Util\JWTAuth;
use Util\QueryBuilder;
use Util\Retorno;

class Desejo extends AppModel
{
    /**
     * Método utilizado para cadastrar um desejo na base de dados.
     *
     * @param  [Array]  $arrDadosDesejo Array de informações do desejo.
     *
     * @return [Array]  Mensagem de erro ou sucesso ao cadastrar desejo.
     */
    public function cadastrar($arrDadosDesejo)
    {
        if (strlen($arrDadosDesejo['description']) > 255) {
            return Retorno::erro('O nome de desejo só pode conter até de 255 caracteres.');
        }

        // Salva no banco de dados.
        $salvaDesejo = $this->execute(QueryBuilder::insert('Products', $arrDadosDesejo), $arrDadosDesejo);

        if ($salvaDesejo) {
            return Retorno::sucesso('Desejo cadastrado com sucesso.');
        }else{
            return Retorno::erro('Algo de errado aconteceu no cadastro, contate o administrador do sistema.');
        }
    }

    /**
     * Método responsável por listar os desejos cadastrados no banco de dados.
     *
     * @param  [Integer] $idDesejo ID do desejo (Opcional)
     * @return [Array]              Lista de desejos.
     */
    public function listar($pesquisaDesejo = null)
    {
        if ($pesquisaDesejo['description'] != '') {
            $desejo = $this->select(QueryBuilder::select('Products', [], ['description' => '']), ['description' => $pesquisaDesejo['description']]);
            if ($desejo) {
                return Retorno::sucesso($desejo);
            }else{
                return Retorno::erro('Desejo nao encontrado.');
            }
        }
        $sql = "SELECT * FROM Products;";

        $desejo = $this->executeSQL($sql, []);
        if ($desejo) {
            return Retorno::sucesso($desejo);
        }else{
            return Retorno::erro('Nenhum desejo encontrado.');
        }
    }

    /**
     * Método responsável por alterar os dados de um desejo no banco de dados.
     *
     * @param  [Integer] $idDesejo     ID do desejo que receberá as alterações.
     * @param  [Array]   $arrAlteracoes Dados de alteração do desejo.
     * @return [Array]                  Mensagem de sucesso
     */
    public function meusDesejos($userId)
    {
        if (!$userId) {
            return Retorno::erro('Favor informar o id do desejo a ser alterado.');
        }

        $sql = "SELECT Products.description, Products.value FROM Products
                INNER JOIN User
                INNER JOIN Desejo
                WHERE Desejo.iduser = :iduser
                group by Products.description, Products.value";

        $desejo = $this->executeSQL($sql, [':iduser' => $userId]);
        if ($desejo) {
            return Retorno::sucesso($desejo);
        }else{
            return Retorno::erro('Não possui desejos cadastrados.');
        }
    }

    /**
     * Método responsável por alterar os dados de um desejo no banco de dados.
     *
     * @param  [Integer] $idDesejo     ID do desejo que receberá as alterações.
     * @param  [Array]   $arrAlteracoes Dados de alteração do desejo.
     * @return [Array]                  Mensagem de sucesso
     */
    public function gruposDesejo($userId)
    {
        if (!$userId) {
            return Retorno::erro('Favor informar o id do desejo a ser alterado.');
        }

        $sql = "SELECT p.idproducts, p.description, p.value, u.iduser, u.name as username, g.name as gruponame
                FROM Products as p
                LEFT JOIN Desejo as d
					ON p.idproducts = d.idproducts
				LEFT JOIN User as u
					ON u.iduser = d.iduser
				LEFT JOIN Groups_in as gin
					ON gin.iduser = u.iduser
				LEFT JOIN Grupo as g
					ON g.idgroup = gin.idgroup
                WHERE d.iduser <> :iduser";

        $desejo = $this->executeSQL($sql, [':iduser' => $userId]);
        if ($desejo) {
            return Retorno::sucesso($desejo);
        }else{
            return Retorno::erro('Algo de errado aconteceu na alteracao, contate o administrador do sistema.');
        }
    }
}
