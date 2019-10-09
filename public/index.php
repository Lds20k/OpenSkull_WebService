<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

include_once '../control/controleUsuario.php';

$app = AppFactory::create();

$app->group('/api', function(RouteCollectorProxy $group){

    $group->get('/', function(Request $request, Response $response, $args) {
        $usuario = json_encode(ControleUsuario::inserir(20));
        $response->getBody()->write($usuario);
        return $response->withHeader('Content-Type', 'application/json');;
    });

});

$app->run();
