<?php 
include_once 'dao/licaoDAO.php';
include_once 'controleModulo.php';

abstract class ControleLicao{

	public static function inserir($args){
		try{
			if(sizeof($args) == 3){
				$args     = (Object)$args;
				$resposta = LicaoDAO::inserir($args);
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
			$resposta = LicaoDAO::consultar($idModulo);
		}catch(Exception $ex){
			$resposta = ['status' => false];
		}
		return $resposta;
	}
	
	public static function consultarUm($id){
		try{
			$resposta = LicaoDAO::consultarUm($id);
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