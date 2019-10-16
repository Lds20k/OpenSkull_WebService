<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

require '../control/controleUsuario.php';
require '../control/controleCurso.php';
require '../control/controleModulo.php';
require '../control/controleLicao.php';

$app = AppFactory::create();

$app->group('/api', function(RouteCollectorProxy $group){
    
    $group->group('/usuario', function(RouteCollectorProxy $group){

        //Insere
        $group->post('', function(Request $request, Response $response, $args) {
            $usuario = json_encode( ControleUsuario::inserir( $request->getQueryParams() ) );
            $response->getBody()->write($usuario);
            return $response->withHeader('Content-Type', 'application/json');
        });

        //Get todos
        $group->get('', function(Request $request, Response $response, $args) {
            $usuarios = json_encode(ControleUsuario::consultar());
            $response->getBody()->write($usuarios);
            return $response->withHeader('Content-Type', 'application/json');
        });
        
        //Get um
        $group->get('/{key}', function(Request $request, Response $response, $args) {
            $usuarios = json_encode(ControleUsuario::consultarUm( $args['key'] ));
            $response->getBody()->write($usuarios);
            return $response->withHeader('Content-Type', 'application/json');
        });

        //Deleta um
        $group->delete('/{id}', function (Request $request, Response $response, $args) {
    		$resposta = json_encode( ControleUsuario::deletar( $args['id']) );
    		$response->getBody()->write($resposta);
    		return $response;
        });
        
        //Retorna um jwt para login
        $group->post('/jwt', function(Request $request, Response $response, $args) {
            $usuario = json_encode( ControleUsuario::getJWT( $request->getQueryParams() ) );
            $response->getBody()->write($usuario);
            return $response->withHeader('Content-Type', 'application/json');
        });

        //Atualiza um
        $group->put('/{jwt}', function(Request $request, Response $response, $args) {
            $usuario = json_encode( ControleUsuario::atualizar( $args['jwt'], $request->getQueryParams() ) );
            $response->getBody()->write($usuario);
            return $response->withHeader('Content-Type', 'application/json');
        });
    });

    $group->group('/curso', function(RouteCollectorProxy $group){

        //Insere
        $group->post('', function(Request $request, Response $response, $args) { 
            $curso = json_encode(ControleCurso::inserir( $request->getQueryParams() ));
            $response->getBody()->write($curso);
            return $response->withHeader('Content-Type', 'application/json');
        });

        //Get todos
        $group->get('', function(Request $request, Response $response, $args) {
            $curso = json_encode(ControleCurso::consultar());
            $response->getBody()->write($curso);
            return $response->withHeader('Content-Type', 'application/json');
        });

        //Get um
        $group->get('/{id}', function(Request $request, Response $response, $args) {
            $usuarios = json_encode(ControleCurso::consultarUm( $args['id'] ));
            $response->getBody()->write($usuarios);
            return $response->withHeader('Content-Type', 'application/json');
        });

        //Deleta um
        $group->delete('/{id}', function (Request $request, Response $response, $args) {
            $resposta = json_encode( ControleCurso::deletar( $args['id']) );
            $response->getBody()->write($resposta);
            return $response;
        });
    });

    $group->group('/modulo', function(RouteCollectorProxy $group){

        //Insere
        $group->post('', function(Request $request, Response $response, $args) {
            $modulo = json_encode( ControleModulo::inserir( $request->getQueryParams() ) );
            $response->getBody()->write($modulo);
            return $response->withHeader('Content-Type', 'application/json');
        });

        //Get todos os modulos de um curso
        $group->get('/all/{idCurso}', function(Request $request, Response $response, $args) {
            $modulos = json_encode(ControleModulo::consultar($args['idCurso']));
            $response->getBody()->write($modulos);
            return $response->withHeader('Content-Type', 'application/json');
        });

        //Get um modulo
        $group->get('/one/{id}', function(Request $request, Response $response, $args) {
            $modulo = json_encode(ControleModulo::consultarUm( $args['id'] ));
            $response->getBody()->write($modulo);
            return $response->withHeader('Content-Type', 'application/json');
        });
    });

    $group->group('/licao', function(RouteCollectorProxy $group){

        //Insere
        $group->post('', function(Request $request, Response $response, $args) {
            $licao = json_encode( ControleLicao::inserir( $request->getQueryParams() ) );
            $response->getBody()->write($licao);
            return $response->withHeader('Content-Type', 'application/json');
        });
    });
});

$app->run();
