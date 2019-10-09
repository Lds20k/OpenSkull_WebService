<?php
include_once 'controle.php';
include_once 'controleUsuario.php';
include_once '../model/usuario.php';
include_once '../model/curso.php';


abstract class ControleCurso extends Controle{
	public static function inserir($jwt, $nome, $imagem, $horas, $descricao, $preco){
		try {
			$dados = JWT::decode($jwt);
			$usuario = ControleUsuario::consultarUm($dados->id);
			$curso = new Curso(null, $usuario, $nome, $imagem, $horas, $descricao, $preco);
		} catch (Exception $e) {
			
		}
	}

	public static function atualizar($id, $jwt, $criador = null, $nome = null, $imagem = null, $horas = null, $descricao = null, $preco = null){
		try{
			$dados = JWT::decode($jwt);
			$usuario = ControleUsuario::consultarUm($dados->id);
			$curso = new Curso($id, $usuario, $nome, $imagem, $horas, $descricao, $preco);
		}catch(Exception $e){

		}
	}

	public static function consultar(){
		
	}

	public static function consultarUm($id){

	}

	public static function deletar($id){

	}
}