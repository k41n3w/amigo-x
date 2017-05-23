<?php

use Model\Usuario;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Agrupa as rotas referente a manipulação de usuarios
$app->group('/usuario', function () use ($app) {
    $objUsuario = new Usuario();

    /**
     * Método utilizado: POST
     * Parâmetros esperados: [String] strLogin
     *                       [String] strSenha
     *
     *
     * Retorno: Resposta no formato JSON contendo o token e informações de login.
     */
    $app->post('/login', function (Request $request, Response $response) use ($objUsuario) {
        $arrRequest = array_map('trim', $request->getParsedBody());
        return $response->withJson($objUsuario->login($arrRequest['strLogin'], $arrRequest['strSenha']), 200, JSON_NUMERIC_CHECK);
    });


    /**
     * Método utilizado: POST
     * Parâmetros esperados: [String]  nome
     *                       [String]  login
     *                       [String]  senha
     *
     *
     * Retorno: Resposta no formato JSON contendo as informações do cadastro do usuário.
     */
    $app->post('/cadastrar-usuario', function (Request $request, Response $response) use ($objUsuario) {
        $arrRequest = $request->getParsedBody();
        return $response->withJson($objUsuario->cadastrar($arrRequest));
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
    $app->post('/alterar-usuario', function (Request $request, Response $response) use ($objUsuario) {
        $arrRequest = $request->getParsedBody();
        return $response->withJson($objUsuario->alterar($arrRequest['id'], $arrRequest['dados']));
    });

    /**
     * Método utilizado: GET
     *
     * Nivel de Acesso: Gerente
     *
     * Retorno: Lista de Usuários cadastrados.
     */
    $app->post('/listar-usuarios', function (Request $request, Response $response) use ($objUsuario) {
        $arrRequest = $request->getParsedBody();
        return $response->withJson($objUsuario->listar($arrRequest), 200, JSON_NUMERIC_CHECK);
    });

    /*
     * Método utilizado: POST
     * Parâmetros esperados: [String] senhaAntiga
     * Parâmetros esperados: [String] senhaNova
     *
     * Nivel de Acesso: Basico
     *
     * Retorno: Mensagem de sucesso.
     */
    $app->post('/alterar-senha', function (Request $request, Response $response) use ($objUsuario) {
        $arrRequest = array_map('trim', $request->getParsedBody());
        return $response->withJson($objUsuario->alterarSenha($this->jwt->dadosUsuario->userId, $arrRequest));
    });


});
