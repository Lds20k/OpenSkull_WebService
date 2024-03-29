<?php

require_once(__DIR__ . '/controleCurso.php');
require_once(__DIR__ . '/../model/curso.php');
require_once(__DIR__ . '/../model/modulo.php');
require_once(__DIR__ . '/../model/usuario.php');
require_once(__DIR__ . '/dao/moduloDAO.php');

abstract class ControleModulo{
	public static function inserir($args){
		try {
			if(sizeof($args) == 3){
				$args     = (object)$args;
				$dados    = OpenSkullJWT::decodificar($args->jwt);

				$usuario  = new Usuario($dados->dados->id);
				$curso	  = new Curso($args->idCurso, $usuario);
				CursoDAO::verificarCriador($curso);
				$modulo   = new Modulo(null, null, $args->nome);
				$curso->addModulo($modulo);

				$resposta = ModuloDAO::inserir($curso);
			}else{
                $resposta = ['status' => false];
            }
		} catch (Exception $ex) {
			$resposta = ['status' => false];
		}
		return $resposta;
	}

	public static function consultar($idCurso){
		try{
			$resposta = ModuloDAO::consultar($idCurso);
		}catch(Exception $ex){
			$resposta = ['status' => false];
		}
		return $resposta;
	}

	public static function consultarUm($id){
		try{
			$resposta = ModuloDAO::consultarUm($id);
		}catch(Exception $ex){
			$resposta = ['status' => false];
			echo $ex;
		}
		return $resposta;
	}

	public static function deletar($id ,$jwt){
		try{
			$dados    = OpenSkullJWT::decodificar($jwt);

			$usuario  = new Usuario($dados->dados->id);
			$modulo	  = new Modulo($id);
			$curso	  = ModuloDAO::getCurso($modulo, $usuario);

			CursoDAO::verificarCriador($curso);

			$resposta = ModuloDAO::deletar($modulo);
		}catch(Exception $ex){
			$resposta = ['status' => false];
		}
		return $resposta;
	}

	public static function atualizar($id, $args){
		try{
			$args      = (object)$args;
			$modulo    = new Modulo($id, null, $args->nome);
			$dados     = OpenSkullJWT::decodificar($args->jwt);
			CursoDAO::verificarCriador(ModuloDAO::getCurso($modulo, new Usuario($dados->dados->id)));
			$resposta = ModuloDAO::atualizar($modulo);
		}catch(Exception $ex){
			$resposta = ['status' => false];
		}
		return $resposta;
	}
}