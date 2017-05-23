<?php

use Model\Venda;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Agrupa as rotas referente a manipulação de vendas
$app->group('/venda', function () use ($app) {
    $objVenda = new Venda();
    /**
     * Método utilizado: POST
     * Parâmetros esperados: [String]  nome
     *                       [String]  login
     *                       [String]  senha
     *
     *
     * Retorno: Resposta no formato JSON contendo as informações do cadastro do venda.
     */
    $app->post('/cadastrar-venda', function (Request $request, Response $response) use ($objVenda) {
        $arrRequest = $request->getParsedBody();
        return $response->withJson($objVenda->cadastrar($arrRequest));
    });

    /**
     * Método utilizado: GET
     *
     * Nivel de Acesso: Gerente
     *
     * Retorno: Lista de vendas cadastrados.
     */
    $app->post('/listar-vendas', function (Request $request, Response $response) use ($objVenda) {
        $arrRequest = $request->getParsedBody();
        return $response->withJson($objVenda->listar($arrRequest), 200, JSON_NUMERIC_CHECK);
    });

});
