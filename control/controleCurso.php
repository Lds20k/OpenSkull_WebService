<?php
use \Firebase\JWT\JWT;

require_once(__DIR__ . '/controle.php');
require_once(__DIR__ . '/controleUsuario.php');
require_once(__DIR__ . '/../model/usuario.php');
require_once(__DIR__ . '/../model/curso.php');
require_once(__DIR__ . '/dao/cursoDAO.php');
require_once(__DIR__ . '/../model/jwt.php');

abstract class ControleCurso{
	public static function inserir($args){
		try {
			if(!isset($imagem)){
                $imagem = null;
            }

            if(sizeof($args) == 6){
            	$args = (Object)$args;
            	$dados = OpenSkullJWT::decodificar($args->jwt);
				$usuario = ControleUsuario::consultarUm($dados->dados->id);
				$usuario = new Usuario($usuario['usuario']->id, null, null, null, null, null, null, null, null, null);
				$licao   = Array(new Licao(null, null, null));
        		$modulo  = new Modulo(null, $licao, null);
				$curso = new Curso(null, $usuario, $args->nome, $args->imagem, $args->horas, $args->descricao, $args->preco, $modulo);
				$resposta = CursoDAO::inserir($curso);
            }else{
            	$resposta = ['status' => false];
            }
		} catch (Exception $ex) {
			$resposta = ['status' => false];
			echo $ex;
		}
		return $resposta;
	}

	public static function consultar(){
		try{
			$resposta = CursoDAO::consultar();
		}catch(Exception $ex){
			return ['status' => false];
		}
		return $resposta;
	}

	public static function consultarUm($id){
		try{
			$resposta = CursoDAO::consultarUm($id);
		}catch(Exception $ex){
			$resposta = ['status' => false];
		}
		return $resposta;
	}

	public static function deletar($id){
		try{
			$resposta = CursoDAO::deletar($id);
		}catch(Exception $ex){
			$resposta = ['status' => false];
		}
		return $resposta;
	}

	public static function atualizar($id, $jwt, $criador = null, $nome = null, $imagem = null, $horas = null, $descricao = null, $preco = null){
		
	}

	public static function consultarPorUsuario($key){
		try{
			if(OpenSkullJWT::verificar($key)){
                $key = OpenSkullJWT::decodificar($key)->dados->id;
            }
			$resposta = CursoDAO::consultarPorUsuario($key);
			
		}catch(Exception $ex){
			$resposta = ['status' => false];
		}
		return $resposta;
	}
}