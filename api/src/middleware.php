<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Middleware\JwtAuthentication;
use Slim\Middleware\JwtAuthentication\RequestPathRule;
use Slim\Middleware\JwtAuthentication\RequestMethodRule;
use Exception\ErrorHandler;
use Configuration\Configuration;
use Util\Retorno;
use phpmailer\phpmailer\PHPMailerAutoload as PHPMailer;

$container = $app->getContainer();

$container["jwt"] = function ($container) {
    return new StdClass;
};

// Mensagem customizada de erro.
// $container["errorHandler"] = function ($container) {
//     return new ErrorHandler();
// };

// Cria um Objeto do tipo Histórico.
// $container["historico"] = new Historico();

/**
 * Validações de rota e tempo de validade do token
 */
$app->add(function(Request $request, Response $response, callable $next){
    $responseInterface = $next($request, $response);
    if ($request->getMethod() === "OPTIONS") {
        return $responseInterface
            ->withStatus(200)
            ->withJson(Retorno::sucesso('Ok.'));
    }

    $arrRotasAdmin = [];

    // Se houver um token no cabeçalho, verificar o tempo de validade dele.
    if (!empty($request->getHeader('Authorization')[0])) {
        if (!empty((array)$this->jwt)) {
            if (strtotime('-12 hours') > $this->jwt->dataHoraCriacao) {
                return $responseInterface
                ->withStatus(401)
                ->withJson(Retorno::outro('Token Expirado.'));
            }
        }
    }

    return $responseInterface;
});

/**
 * Configurações de automação do JWT
 */
$app->add(new JwtAuthentication([
    "path" => ['/'],
    "secure" => false,
    "passthrough" => ['/usuario/login', '/usuario/cadastrar-usuario'],
    "secret" => Configuration::read("authentication")['jwtKey'],
    "algorithm" => Configuration::read("authentication")['algorithm'],
    "callback" => function ($request, $response, $arguments) use ($container) {
        $container["jwt"] = $arguments["decoded"];
    }
]));

/**
 * Cabeçalhos
 */
$app->add(function (Request $request, Response $response, callable $next) {
    $responseInterface = $next($request, $response);
    return $responseInterface
      ->withHeader('Content-Type', 'application/json')
      ->withHeader('Access-Control-Allow-Origin', '*')
      ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
      ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});
