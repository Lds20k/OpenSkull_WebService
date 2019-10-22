<?php

include_once 'controleCurso.php';
include_once '../model/curso.php';
include_once '../model/modulo.php';
include_once '../model/usuario.php';
include_once 'dao/moduloDAO.php';

abstract class ControleModulo{
	public static function inserir($args){
		try {
			if(sizeof($args) == 2){
				$args     = (object)$args;
				$resposta = ModuloDAO::inserir($args);
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
			echo $ex;
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

	public static function deletar(){
		try{

		}catch(Exception $ex){
			$resposta = ['status' => false];			
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
}