<?php 
include_once 'dao/licaoDAO.php';
include_once 'controleModulo.php';

abstract class ControleLicao{

	public static function inserir($args){
		try{
			if(sizeof($args) == 3){
				$args     = (Object)$args;
				$modulo   = ControleModulo::consultarUm($args->idModulo);
				$curso    = $modulo['modulo']->curso;
				$criador  = $modulo['modulo']->curso->criador;


				$criador  = new Usuario($criador->id, $criador->dataNascimento, $criador->tipo, $criador->email, null, $criador->nome, $criador->sobrenome, $criador->instituicao, $criador->imagem, $criador->biografia);
				$curso    = new Curso($curso->id, $criador, $curso->nome, $curso->imagem, $curso->horas, $curso->descricao, $curso->preco);
				$modulo   = new Modulo($args->idModulo, $curso, $modulo['modulo']->nome);
				$licao    = new Licao(null, $modulo, $args->nome, $args->conteudo);
				$resposta = LicaoDAO::inserir($licao);
			}else{
				$resposta = ['status' => false];
			}
		}catch(Exception $ex){
			$resposta = ['status' => false];
			echo $ex;
		}
		return $resposta;
	}
	
	public static function atualizar(){
		try{

		}catch(Exception $ex){
			$resposta = ['status' => false];
		}
		return $resposta;
	}
	
	public static function consultar($idModulo){
		try{

		}catch(Exception $ex){
			$resposta = ['status' => false];
		}
		return $resposta;
	}
	
	public static function consultarUm($id){
		try{

		}catch(Exception $ex){
			$resposta = ['status' => false];
		}
		return $resposta;
	}
	
	public static function deletar($id){
		try{

		}catch(Exception $ex){
			$resposta = ['status' => false];
		}
		return $resposta;
	}
}