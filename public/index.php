<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

require '../control/controleUsuario.php';
require '../control/controleCurso.php';

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
        $group->get('/{key}', function(Request $request, Response $response, $args) {
            $usuarios = json_encode(ControleUsuario::consultarUm($args['key']));
            $response->getBody()->write($usuarios);
            return $response->withHeader('Content-Type', 'application/json');;
        });

        //Deleta um
        $group->delete('/{id}', function (Request $request, Response $response, $args) {
    		$resposta = json_encode( ControleUsuario::deletar($args['id']) );
    		$response->getBody()->write($resposta);
    		return $response;
        });
        
        //Retorna um jwt para login
        $group->post('/jwt', function(Request $request, Response $response, $args) {
            $usuario = json_encode( ControleUsuario::getJWT( $request->getQueryParams() ) );
            $response->getBody()->write($usuario);
            return $response->withHeader('Content-Type', 'application/json');;
        });
    });

    $group->group('/curso', function(RouteCollectorProxy $group){

        //Insere
        $group->post('', function(Request $request, Response $response, $args) { 
            $curso = json_encode(ControleCurso::inserir( $request->getQueryParams() ));
            $response->getBody()->write($curso);
            return $response->withHeader('Content-Type', 'application/json');;
        });

        //Get todos
        $group->get('', function(Request $request, Response $response, $args) {
            $curso = json_encode(ControleCurso::consultar());
            $response->getBody()->write($curso);
            return $response->withHeader('Content-Type', 'application/json');;
        });
    });
});

$app->run();
