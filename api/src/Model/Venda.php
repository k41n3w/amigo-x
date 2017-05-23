<?php

namespace Model;

use PDO;
use Util\JWTAuth;
use Util\QueryBuilder;
use Util\Retorno;

class Venda extends AppModel
{
    /**
     * Método utilizado para cadastrar um venda na base de dados.
     *
     * @param  [Array]  $arrDadosVenda Array de informações do venda.
     *
     * @return [Array]  Mensagem de erro ou sucesso ao cadastrar venda.
     */
    public function cadastrar($arrDadosVenda)
    {
        // Verifica se já existe se ja existe o usuario cadastrado no sistema.
        $Usuario = $this->select(QueryBuilder::select('User', [], ['iduser' => '']), ['iduser' => $arrDadosVenda['iduser']]);
        if (!$Usuario) {
            return Retorno::erro('Usuario não cadastrado no sistema.');
        }

        // Verifica se já existe se ja existe o produto cadastrado no sistema.
        $Produto = $this->select(QueryBuilder::select('Products', [], ['idproducts' => '']), ['idproducts' => $arrDadosVenda['idproducts']]);
        if (!$Produto) {
            return Retorno::erro('Produto não cadastrado no sistema.');
        }

        // Salva no banco de dados.
        $salvaVenda = $this->execute(QueryBuilder::insert('Sells', $arrDadosVenda), $arrDadosVenda);

        if ($salvaVenda) {
            return Retorno::sucesso('Venda cadastrado com sucesso.');
        }else{
            return Retorno::erro('Algo de errado aconteceu no cadastro, contate o administrador do sistema.');
        }
    }

    /**
     * Método responsável por listar os vendas cadastrados no banco de dados.
     *
     * @param  [Integer] $idVenda ID do venda (Opcional)
     * @return [Array]              Lista de vendas.
     */
    public function listar($pesquisaVenda = null)
    {
        if ($pesquisaVenda) {
            $venda = $this->select(QueryBuilder::select('Sells', [], ['iduser' => '']), ['iduser' => $pesquisaVenda['iduser']]);
            if ($venda) {
                return Retorno::sucesso($venda);
            }else{
                return Retorno::erro('Venda nao encontrado.');
            }
        }
        $sql = "SELECT * FROM Products;";

        $venda = $this->executeSQL($sql, []);
        if ($venda) {
            return Retorno::sucesso($venda);
        }else{
            return Retorno::erro('Nenhum venda encontrado.');
        }
    }

}
