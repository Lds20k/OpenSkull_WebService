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
				$curso    = ControleCurso::consultarUm($args->idCurso);
				$criador  = $curso['curso']->criador;
				$curso    = $curso['curso'];

				
				$criador  = new Usuario($criador->id, $criador->dataNascimento, $criador->tipo, $criador->email, null, $criador->nome, $criador->sobrenome, $criador->instituicao, $criador->imagem, $criador->biografia);
				$curso    = new Curso($curso->id, $criador, $curso->nome,  $curso->imagem, $curso->horas, $curso->descricao, $curso->preco);
				$modulo   = new Modulo(null, $curso, $args->nome);
				$resposta = ModuloDAO::inserir($modulo);
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

	public static function consultarUm($id/*Modulo*/){
		try{
			$resposta = ModuloDAO::consultarUm($id/*Modulo*/);
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