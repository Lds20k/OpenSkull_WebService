<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;
use Slim\Factory\AppFactory;

require '../vendor/autoload.php';

require '../control/controleUsuario.php';

$app = AppFactory::create();

//$app->addErrorMiddleware(false, true, true);

$app->group('/api', function(RouteCollectorProxy $group){
    
    $group->group('/usuario', function(RouteCollectorProxy $group){

        $group->post('/inserir', function(Request $request, Response $response, $args) {
            var_dump($request->getUri()->getQuery());
            $group->post['dataNascimento'];
            $usuarioJSON = $request->dataNascimeto;
            $usuario = json_encode( ControleUsuario::inserir($usuarioJSON->dataNascimento));
            $response->getBody()->write($usuario);
            return $response->withHeader('Content-Type', 'application/json');;
        });

    });

});

$app->run();
