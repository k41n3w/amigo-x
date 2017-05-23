<?php

use Model\Produto;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Agrupa as rotas referente a manipulação de produtos
$app->group('/produto', function () use ($app) {
    $objProduto = new Produto();
    /**
     * Método utilizado: POST
     * Parâmetros esperados: [String]  nome
     *                       [String]  login
     *                       [String]  senha
     *
     *
     * Retorno: Resposta no formato JSON contendo as informações do cadastro do usuário.
     */
    $app->post('/cadastrar-produto', function (Request $request, Response $response) use ($objProduto) {
        $arrRequest = $request->getParsedBody();
        return $response->withJson($objProduto->cadastrar($arrRequest));
    });

    /**
     * Método utilizado: POST
     * Parâmetros esperados: [String] id
     *                       [Array/Object] dados
     *
     * Nivel de Acesso: Gerente
     *
     * Retorno: Mensagem de sucesso.
     */
    $app->post('/comprar-produto', function (Request $request, Response $response) use ($objProduto) {
        $arrRequest = $request->getParsedBody();
        return $response->withJson($objProduto->comprar($this->jwt->dadosUsuario->userId, $arrRequest));
    });

    /**
     * Método utilizado: POST
     * Parâmetros esperados: [String] id
     *                       [Array/Object] dados
     *
     * Nivel de Acesso: Gerente
     *
     * Retorno: Mensagem de sucesso.
     */
    $app->post('/desejar-produto', function (Request $request, Response $response) use ($objProduto) {
        $arrRequest = $request->getParsedBody();
        return $response->withJson($objProduto->desejar($this->jwt->dadosUsuario->userId, $arrRequest));
    });

    /**
     * Método utilizado: GET
     *
     * Nivel de Acesso: Gerente
     *
     * Retorno: Lista de Usuários cadastrados.
     */
    $app->post('/listar-produtos', function (Request $request, Response $response) use ($objProduto) {
        $arrRequest = $request->getParsedBody();
        return $response->withJson($objProduto->listar($arrRequest));
    });

});
