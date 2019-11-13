<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;
use Slim\Factory\AppFactory;

require_once(__DIR__ . '/../vendor/autoload.php');
//Inclui todos os controles
require_once(__DIR__ . '/../control/controleUsuario.php');
require_once(__DIR__ . '/../control/controleCurso.php');
require_once(__DIR__ . '/../control/controleModulo.php');
require_once(__DIR__ . '/../control/controleLicao.php');

$app = AppFactory::create();

//Tirar as tag somente no Cotil
//$app->add(function ($request, $handler) {
//    $response = $handler->handle($request);
//    return $response
//            ->withHeader('Access-Control-Allow-Origin', '*')
//            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
//            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
//});

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

        //Atualizar
        $group->put('/{jwt}', function(Request $request, Response $response, $args) {
            $usuario = json_encode( ControleUsuario::atualizar( $args['jwt'], $request->getQueryParams() ) );
            $response->getBody()->write($usuario);
            return $response->withHeader('Content-Type', 'application/json');
        });

        //Adiciona um curso para o usuario
        $group->post('/curso/adicionar', function(Request $request, Response $response, $args) { 
            $resposta = json_encode(ControleUsuario::adicionarCurso( $request->getQueryParams() ));
            $response->getBody()->write($resposta);
            return $response->withHeader('Content-Type', 'application/json');
        });

        //Pega os cursos para ativar
        $group->get('/curso/desativados', function(Request $request, Response $response, $args) { 
            $resposta = json_encode(ControleUsuario::desativados());
            $response->getBody()->write($resposta);
            return $response->withHeader('Content-Type', 'application/json');
        });

        $group->post('/curso/ativar', function(Request $request, Response $response, $args) { 
            $resposta = json_encode(ControleUsuario::ativar( $request->getQueryParams() ));
            $response->getBody()->write($resposta);
            return $response->withHeader('Content-Type', 'application/json');
        });

        $group->group('/curso', function(RouteCollectorProxy $group){
            $group->get('/{key}', function(Request $request, Response $response, $args) {
                $cursos = json_encode( ControleUsuario::consultarCursos( $args['key'] ) );
                $response->getBody()->write($cursos);
                return $response->withHeader('Content-Type', 'application/json');
            });
        });

    });

    $group->group('/curso', function(RouteCollectorProxy $group){

        //Insere
        $group->post('', function(Request $request, Response $response, $args) { 
            $curso = json_encode(ControleCurso::inserir( $request->getQueryParams(), $request->getUploadedFiles() ));
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
        $group->delete('/{id}/{jwt}', function (Request $request, Response $response, $args) {
            $resposta = json_encode( ControleCurso::deletar( $args['id'], $args['jwt']) );
            $response->getBody()->write($resposta);
            return $response;
        });

        //Consultar todos os cursos feito pelo usuario
        $group->get('/usuario/{key}', function(Request $request, Response $response, $args) {
            $cursos = json_encode(ControleCurso::consultarPorUsuario( $args['key'] ) );
            $response->getBody()->write($cursos);
            return $response->withHeader('Content-Type', 'application/json');
        });

        //Atualizar
        $group->post('/atualizar/{jwt}', function(Request $request, Response $response, $args) {
            $resposta = json_encode( ControleCurso::atualizar( $args['jwt'], $request->getQueryParams(), $request->getUploadedFiles() ) );
            $response->getBody()->write($resposta);
            return $response->withHeader('Content-Type', 'application/json');
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

        $group->put('/{id}', function(Request $request, Response $response, $args) {
            $usuario = json_encode( ControleModulo::atualizar( $args['id'], $request->getQueryParams() ) );
            $response->getBody()->write($usuario);
            return $response->withHeader('Content-Type', 'application/json');
        });

        //Deleta um
        $group->delete('/{id}/{jwt}', function (Request $request, Response $response, $args) {
            $resposta = json_encode( ControleModulo::deletar( $args['id'], $args['jwt'] ) );
            $response->getBody()->write($resposta);
            return $response;
        });
    });

    $group->group('/licao', function(RouteCollectorProxy $group){

        //Insere
        $group->post('', function(Request $request, Response $response, $args) {
            $licao = json_encode( ControleLicao::inserir( $request->getQueryParams(), $request->getUploadedFiles()) );
            $response->getBody()->write($licao);
            return $response->withHeader('Content-Type', 'application/json');
        });

        //Get todos as licoes de um modulo
        $group->get('/all/{idModulo}', function(Request $request, Response $response, $args) {
            $licoes = json_encode(ControleLicao::consultar($args['idModulo']));
            $response->getBody()->write($licoes);
            return $response->withHeader('Content-Type', 'application/json');
        });

        //Get uma licao
        $group->get('/one/{id}', function(Request $request, Response $response, $args) {
            $licao = json_encode(ControleLicao::consultarUm( $args['id'] ));
            $response->getBody()->write($licao);
            return $response->withHeader('Content-Type', 'application/json');
        });

        //Deleta um
        $group->delete('/{id}/{jwt}', function (Request $request, Response $response, $args) {
            $resposta = json_encode( ControleLicao::deletar( $args['id'], $args['jwt'] ) );
            $response->getBody()->write($resposta);
            return $response;
        });
        
        //Atualizar
        $group->put('/{id}', function(Request $request, Response $response, $args) {
            $licao = json_encode( ControleLicao::atualizar( $args['id'], $request->getQueryParams()) );
            $response->getBody()->write($licao);
            return $response->withHeader('Content-Type', 'application/json');
        });
    });
});

$app->run();
