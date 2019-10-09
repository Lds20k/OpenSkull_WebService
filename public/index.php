<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

include_once '../control/controleUsuario.php';

$app = AppFactory::create();

$app->group('/api', function(RouteCollectorProxy $group){
    
    $group->group('/usuario', function(RouteCollectorProxy $group){
        
        $group->get('/inserir', function(Request $request, Response $response, $args) {
            $usuario = json_encode(ControleUsuario::inserir(20));
            $response->getBody()->write($usuario);
            return $response->withHeader('Content-Type', 'application/json');;
        });

        $group->get('/consultar', function(Request $request, Response $response, $args) {
            $usuarios = json_encode(ControleUsuario::consultar());
            $response->getBody()->write($usuarios);
            return $response->withHeader('Content-Type', 'application/json');;
        });
        
        $group->get('/consultarUm', function(Request $request, Response $response, $args) {
            $usuarios = json_encode(ControleUsuario::consultarUm(1));
            $response->getBody()->write($usuarios);
            return $response->withHeader('Content-Type', 'application/json');;
        });

        $group->delete('/deletar', function (Request $request, Response $response, $args) {
    		ControleUsuario::deletar(1);
    		$response->getBody()->write("");
    		return $response;
		});
    });

});

$app->run();
