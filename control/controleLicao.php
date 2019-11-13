<?php 
require_once(__DIR__ . '/dao/licaoDAO.php');
require_once(__DIR__ . '/controleArquivo.php');

abstract class ControleLicao{

	public static function inserir($args, $file){
		try{
			$args    = (Object)$args;
			$jwt   	 = OpenSkullJWT::decodificar($args->jwt);

			if(!isset($file['video'])){
				$video = new ControleArquivo(null, null);
			}else if($file['video']->getError() === UPLOAD_ERR_OK){
				$video 	 = $file['video'];
				$diretorio = 'midia/videos';
				$video = new ControleArquivo($diretorio, $video);
			}
			$usuario = new Usuario($jwt->dados->id);
			$modulo  = new Modulo($args->idModulo);
			$curso   = ModuloDAO::getCurso($modulo, $usuario);
			CursoDAO::verificarCriador($curso);

			$licao = new Licao(null, $args->nome, isset($args->conteudo) ? $args->conteudo : null, $video->getNomeArquivo());
			$modulo->addLicao($licao);
			$resposta = LicaoDAO::inserir($modulo);
			$video->moverArquivo();
		}catch(Exception $ex){
			$resposta = ['status' => false];
			$video->limparTemp();
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
			echo $ex;
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