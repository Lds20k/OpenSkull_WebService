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

        //Insere
        $group->post('', function(Request $request, Response $response, $args) {
            $usuario = json_encode( ControleUsuario::inserir( $request->getQueryParams() ) );
            $response->getBody()->write($usuario);
            return $response->withHeader('Content-Type', 'application/json');;
        });

        //Get todos
        $group->get('', function(Request $request, Response $response, $args) {
            $usuarios = json_encode(ControleUsuario::consultar());
            $response->getBody()->write($usuarios);
            return $response->withHeader('Content-Type', 'application/json');;
        });
        
        //Get um
        $group->get('/{id}', function(Request $request, Response $response, $args) {
            $usuarios = json_encode(ControleUsuario::consultarUm(1));
            $response->getBody()->write($usuarios);
            return $response->withHeader('Content-Type', 'application/json');;
        });

        //Deleta um
        $group->delete('/{id}', function (Request $request, Response $response, $args) {
    		ControleUsuario::deletar(1);
    		$response->getBody()->write("");
    		return $response;
		});
    });

});

$app->run();
