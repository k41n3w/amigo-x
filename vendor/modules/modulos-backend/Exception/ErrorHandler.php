<?php


namespace Exception;

use Util\Retorno;

class ErrorHandler
{
    public function __invoke($request, $response, $args)
    {
        return $response
                    ->withStatus(500)
                    ->withHeader('Content-Type', 'application/json')
                    ->withJson(Retorno::erro('Algo deu errado. ' . implode(" - ", $args->errorInfo)));
    }
}
