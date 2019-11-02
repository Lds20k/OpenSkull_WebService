<?php
use \Firebase\JWT\JWT;

include_once 'controle.php';
include_once 'controleUsuario.php';
include_once '../model/usuario.php';
include_once '../model/curso.php';
include_once 'dao/cursoDAO.php';
include_once '../model/jwt.php';

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
				$licao   = new Licao(null, null, null);
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