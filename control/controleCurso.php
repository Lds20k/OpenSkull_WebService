<?php
use \Firebase\JWT\JWT;

require_once(__DIR__ . '/controle.php');
require_once(__DIR__ . '/controleUsuario.php');
require_once(__DIR__ . '/../model/usuario.php');
require_once(__DIR__ . '/../model/curso.php');
require_once(__DIR__ . '/dao/cursoDAO.php');
require_once(__DIR__ . '/../model/jwt.php');

abstract class ControleCurso{
	public static function inserir($args, $files){
		try {
			$args = (Object)$args;
			$dados = OpenSkullJWT::decodificar($args->jwt);
			$imagem = $files['imagem'];

			if($imagem->getError() === UPLOAD_ERR_OK){
				$diretorio = 'midia/imagens';
				$imagem = new ControleArquivo($diretorio, $imagem);
			}
			$usuario = ControleUsuario::consultarUm($dados->dados->id);
			$usuario = new Usuario($usuario['usuario']->id, null, null, null, null, null, null, null, null, null);
			$curso = new Curso(null, $usuario, $args->nome, $imagem->getNomeArquivo(), $args->horas, $args->descricao, $args->preco, null);

			$tamanho = getimagesize($imagem->getArquivoTemp());
			if($tamanho[0] !== 255 and $tamanho[1] !== 255)
				throw new Exception("Arquivos devem ter um tamanho fixo de 255x255");
			
			$resposta = CursoDAO::inserir($curso);
			$imagem->moverArquivo();
		} catch (Exception $ex) {
			$resposta = ['status' => false];
			$imagem->limparTemp();
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
			echo $ex;
		}
		return $resposta;
	}

	public static function deletar($id, $args){
		try{
			$args     = (object)$args;
			$dados    = OpenSkullJWT::decodificar($args->jwt);

			$usuario  = new Usuario($dados->dados->id);
			$curso	  = new Curso($id, $usuario);

			CursoDAO::verificarCriador($curso);

			$resposta = CursoDAO::deletar($id);
		}catch(Exception $ex){
			$resposta = ['status' => false];
			echo $ex;
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