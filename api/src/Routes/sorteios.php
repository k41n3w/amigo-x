<?php

use Model\Sorteio;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Agrupa as rotas referente a manipulação de sorteios
$app->group('/sorteio', function () use ($app) {
    $objSorteio = new Sorteio();
    /**
     * Método utilizado: POST
     * Parâmetros esperados: [String]  nome
     *                       [String]  login
     *                       [String]  senha
     *
     *
     * Retorno: Resposta no formato JSON contendo as informações do cadastro do usuário.
     */
    $app->post('/sorteio-grupo', function (Request $request, Response $response) use ($objSorteio) {
        $arrRequest = $request->getParsedBody();
        return $response->withJson($objSorteio->sorteio($arrRequest));
    });

});
