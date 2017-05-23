<?php

use Model\Groups_in;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Agrupa as rotas referente a manipulação de grupos
$app->group('/groups-in', function () use ($app) {
    $objGroups_in = new Groups_in();

    /**
     * Método utilizado: POST
     * Parâmetros esperados: [String]  nome
     *
     *
     * Retorno: Resposta no formato JSON contendo as informações do cadastro do Grupo.
     */
    $app->post('/cadastrar-usuario-grupo', function (Request $request, Response $response) use ($objGroups_in) {
        $arrRequest = $request->getParsedBody();
        return $response->withJson($objGroups_in->cadastrar($arrRequest, $this->jwt->dadosUsuario->userId));
    });

    // /**
    //  * Método utilizado: POST
    //  * Parâmetros esperados: [String] id
    //  *                       [Array/Object] dados
    //  *
    //  * Nivel de Acesso: Gerente
    //  *
    //  * Retorno: Mensagem de sucesso.
    //  */
    // $app->post('/alterar-grupo', function (Request $request, Response $response) use ($objGroups_in) {
    //     $arrRequest = $request->getParsedBody();
    //     return $response->withJson($objGroups_in->alterar($arrRequest['id'], $arrRequest['dados']));
    // });

    /**
     * Método utilizado: GET
     *
     * Nivel de Acesso: Gerente
     *
     * Retorno: Lista de Grupos cadastrados.
     */
    $app->post('/listar-grupo', function (Request $request, Response $response) use ($objGroups_in) {
        $arrRequest = $request->getParsedBody();
        return $response->withJson($objGroups_in->listar($arrRequest), 200, JSON_NUMERIC_CHECK);
    });

    /**
     * Método utilizado: GET
     *
     * Nivel de Acesso: Gerente
     *
     * Retorno: Lista de Grupos cadastrados.
     */
    $app->post('/listar-grupo-usuario', function (Request $request, Response $response) use ($objGroups_in) {
        $arrRequest = $request->getParsedBody();
        return $response->withJson($objGroups_in->listarUsuariosGrupo($arrRequest), 200, JSON_NUMERIC_CHECK);
    });

});
