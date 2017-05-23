<?php

require_once '../vendor/autoload.php';

use Slim\App;

//Configurações do Slim
$settings = [
  'settings' => [
    'displayErrorDetails' => true,
    'determineRouteBeforeAppMiddleware' => true,
    'addContentLengthHeader' => false
  ]
];

$app = new App($settings);

$container = $app->getContainer();

$container['phpErrorHandler'] = function ($container) {
    return function ($request, $response, $error) use ($container) {
        $strNomeArquivo = basename($error->getFile());
        $strCaminhoArquivo = substr($error->getFile(), 0, strpos($error->getFile(), $strNomeArquivo));

        $arrErro = [
            'linha' => $error->getLine(),
            'arquivo' => $strNomeArquivo,
            'caminho' => $strCaminhoArquivo,
            'mensagem' => $error->getMessage(),
            'rastreamento' => htmlentities($error->getTraceAsString())
        ];

        return $container['response']
            ->withStatus(500)
            ->withHeader('Content-type', 'application/json')
            ->withJson($arrErro);
    };
};

// trata excecoes do PHP
$container['errorHandler'] = function ($container) {
    return $container['phpErrorHandler'];
};

// trata os demais erros, warnings e etc
set_error_handler(function ($intErro, $strMensagem, $strArquivo, $intLinha) {
    if (!(error_reporting() & $intErro)) {
        return;
    }

    throw new ErrorException($strMensagem, 0, $intErro, $strArquivo, $intLinha);
});

require_once __DIR__ . '/src/middleware.php';

// Carrega todas as rotas definidas dentro de 'src/Routes'
$dirRotas = new DirectoryIterator(__DIR__ . '/src/Routes');
foreach ($dirRotas as $arquivo) {
    if (!$arquivo->isDot()) {
        if ($arquivo->getExtension() === 'php') {
            require_once $arquivo->getPathname();
        }
    }
}

$app->run();
