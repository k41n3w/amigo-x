<?php

use Model\Grupo;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Agrupa as rotas referente a manipulação de grupos
$app->group('/grupo', function () use ($app) {
    $objGrupo = new Grupo();

    /**
     * Método utilizado: POST
     * Parâmetros esperados: [String]  nome
     *
     *
     * Retorno: Resposta no formato JSON contendo as informações do cadastro do Grupo.
     */
    $app->post('/cadastrar-grupo', function (Request $request, Response $response) use ($objGrupo) {
        $arrRequest = $request->getParsedBody();
        return $response->withJson($objGrupo->cadastrar($arrRequest, $this->jwt->dadosUsuario->userId));
    });


    /**
     * Método utilizado: GET
     *
     * Nivel de Acesso: Gerente
     *
     * Retorno: Lista de Grupos cadastrados.
     */
    $app->post('/listar-grupo', function (Request $request, Response $response) use ($objGrupo) {
        $arrRequest = $request->getParsedBody();
        return $response->withJson($objGrupo->listar($arrRequest, $this->jwt->dadosUsuario->userId));
    });

    /**
     * Método utilizado: GET
     *
     * Nivel de Acesso: Gerente
     *
     * Retorno: Lista de Grupos cadastrados.
     */
    $app->post('/listar-grupo-dashboard', function (Request $request, Response $response) use ($objGrupo) {
        $arrRequest = $request->getParsedBody();
        return $response->withJson($objGrupo->listarDashboard($arrRequest, $this->jwt->dadosUsuario->userId));
    });

});
