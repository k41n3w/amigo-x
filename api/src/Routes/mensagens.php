<?php

use Model\Mensagem;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Agrupa as rotas referente a manipulação de mensagems
$app->group('/mensagem', function () use ($app) {
    $objMensagem = new Mensagem();
    /**
     * Método utilizado: POST
     * Parâmetros esperados: [String]  nome
     *                       [String]  login
     *                       [String]  senha
     *
     *
     * Retorno: Resposta no formato JSON contendo as informações do cadastro do usuário.
     */
    $app->post('/cadastrar-mensagem', function (Request $request, Response $response) use ($objMensagem) {
        $arrRequest = $request->getParsedBody();
        return $response->withJson($objMensagem->cadastrar($arrRequest));
    });

    /**
     * Método utilizado: GET
     *
     * Nivel de Acesso: Gerente
     *
     * Retorno: Lista de Usuários cadastrados.
     */
    $app->post('/listar-mensagens', function (Request $request, Response $response) use ($objMensagem) {
        $arrRequest = $request->getParsedBody();
        return $response->withJson($objMensagem->listar($arrRequest), 200, JSON_NUMERIC_CHECK);
    });

});
