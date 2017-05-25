<?php

namespace Model;

use PDO;
use Util\JWTAuth;
use Util\QueryBuilder;
use Util\Retorno;

class Produto extends AppModel
{
    /**
     * Método utilizado para cadastrar um produto na base de dados.
     *
     * @param  [Array]  $arrDadosProduto Array de informações do produto.
     *
     * @return [Array]  Mensagem de erro ou sucesso ao cadastrar produto.
     */
    public function cadastrar($arrDadosProduto)
    {
        if (strlen($arrDadosProduto['description']) > 255) {
            return Retorno::erro('O nome de produto só pode conter até de 255 caracteres.');
        }

        // Salva no banco de dados.
        $salvaProduto = $this->execute(QueryBuilder::insert('Products', $arrDadosProduto), $arrDadosProduto);

        if ($salvaProduto) {
            return Retorno::sucesso('Produto cadastrado com sucesso.');
        }else{
            return Retorno::erro('Algo de errado aconteceu no cadastro, contate o administrador do sistema.');
        }
    }

    /**
     * Método responsável por listar os produtos cadastrados no banco de dados.
     *
     * @param  [Integer] $idProduto ID do produto (Opcional)
     * @return [Array]              Lista de produtos.
     */
    public function listar($pesquisaProduto = null)
    {
        if ($pesquisaProduto['description'] != '') {
            $produto = $this->select(QueryBuilder::select('Products', [], ['description' => '']), ['description' => $pesquisaProduto['description']]);
            if ($produto) {
                return Retorno::sucesso($produto);
            }else{
                return Retorno::erro('Produto nao encontrado.');
            }
        }
        $sql = "SELECT * FROM Products;";

        $produto = $this->executeSQL($sql, []);
        if ($produto) {
            return Retorno::sucesso($produto);
        }else{
            return Retorno::erro('Nenhum produto encontrado.');
        }
    }

    /**
     * Método responsável por alterar os dados de um produto no banco de dados.
     *
     * @param  [Integer] $idProduto     ID do produto que receberá as alterações.
     * @param  [Array]   $arrAlteracoes Dados de alteração do produto.
     * @return [Array]                  Mensagem de sucesso
     */
    public function comprar($userId, $idProduto)
    {
        if (!$idProduto) {
            return Retorno::erro('Favor informar o id do produto a ser alterado.');
        }

        // Atualiza no banco de dados.
        $arrDadosProduto = [
            'idproducts' => $idProduto['idproducts'],
            'iduser' => $userId
        ];

        $salvaProduto = $this->execute(QueryBuilder::insert('Sells', $arrDadosProduto), $arrDadosProduto);

        if ($salvaProduto) {
            return Retorno::sucesso('Compra efetuada com sucesso.');
        }else{
            return Retorno::erro('Algo de errado aconteceu, contate o administrador do sistema.');
        }
    }

    /**
     * Método responsável por alterar os dados de um produto no banco de dados.
     *
     * @param  [Integer] $idProduto     ID do produto que receberá as alterações.
     * @param  [Array]   $arrAlteracoes Dados de alteração do produto.
     * @return [Array]                  Mensagem de sucesso
     */
    public function desejar($userId, $idProduto)
    {
        if (!$idProduto) {
            return Retorno::erro('Favor informar o id do produto a ser alterado.');
        }

        // Atualiza no banco de dados.
        $arrDadosProduto = [
            'idproducts' => $idProduto['idproducts'],
            'iduser' => $userId
        ];

        $salvaProduto = $this->execute(QueryBuilder::insert('Desejo', $arrDadosProduto), $arrDadosProduto);

        if ($salvaProduto) {
            return Retorno::sucesso('Desejo adicionado a sua lista.');
        }else{
            return Retorno::erro('Algo de errado aconteceu, contate o administrador do sistema.');
        }
    }

    /**
     * Método responsável por listar os produtos cadastrados no banco de dados.
     *
     * @param  [Integer] $idProduto ID do produto (Opcional)
     * @return [Array]              Lista de produtos.
     */
    public function listarMeusProdutos($pesquisaProduto = null)
    {

        $sql = "SELECT p.description, p.idproducts, p.value FROM Products as p
                LEFT JOIN Sells as s
                	ON p.idproducts = s.idproducts
                WHERE s.iduser = :iduser";

        $produto = $this->executeSQL($sql, [':iduser' => $iduser]);
        if ($produto) {
            return Retorno::sucesso($produto);
        }else{
            return Retorno::erro('Nenhum produto encontrado.');
        }
    }
}
