<?php

use Model\Desejo;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Agrupa as rotas referente a manipulação de desejos
$app->group('/desejo', function () use ($app) {
    $objDesejo = new Desejo();
    /**
     * Método utilizado: POST
     * Parâmetros esperados: [String]  nome
     *                       [String]  login
     *                       [String]  senha
     *
     *
     * Retorno: Resposta no formato JSON contendo as informações do cadastro do usuário.
     */
    $app->post('/cadastrar-desejo', function (Request $request, Response $response) use ($objDesejo) {
        $arrRequest = $request->getParsedBody();
        return $response->withJson($objDesejo->cadastrar($arrRequest));
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
    $app->post('/grupos-desejo', function (Request $request, Response $response) use ($objDesejo) {
        //$arrRequest = $request->getParsedBody();
        return $response->withJson($objDesejo->gruposDesejo($this->jwt->dadosUsuario->userId));
    });

    /**
     * Método utilizado: GET
     *
     * Nivel de Acesso: Gerente
     *
     * Retorno: Lista de Usuários cadastrados.
     */
    $app->post('/meus-desejos', function (Request $request, Response $response) use ($objDesejo) {
        $arrRequest = $request->getParsedBody();
        return $response->withJson($objDesejo->meusDesejos($this->jwt->dadosUsuario->userId));
    });

});
