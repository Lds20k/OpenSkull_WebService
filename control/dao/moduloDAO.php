<?php
require_once(__DIR__ . '/../../connect/conexao.php');
require_once(__DIR__ . '/../../model/curso.php');
require_once(__DIR__ . '/../../model/modulo.php');
require_once(__DIR__ . '/../../model/licao.php');

abstract class ModuloDAO{
	public static $tabela = 'modulo';

	public static function getCurso(Modulo $modulo, Usuario $usuario){
		$conexao = ConexaoPDO::getConexao();
		$SQL = 'SELECT '.CursoDAO::$tabela.'.ID, '.CursoDAO::$tabela.'.Criador  FROM '.CursoDAO::$tabela.' INNER JOIN '.ModuloDAO::$tabela.' ON '.ModuloDAO::$tabela.'.ID_Curso = '.CursoDAO::$tabela.'.ID WHERE '.ModuloDAO::$tabela.'.ID = ?';
		$stmt = $conexao->prepare($SQL);
		$modulo = $modulo->converter();

		$stmt->bindParam(1, $modulo->id);
		if(!$stmt->execute()){
			throw new Exception('Erro ao consultar curso e modulo no banco!');
		}
		$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
		return new Curso($resultado['ID'], $usuario);
	}

	public static function inserir(Curso $curso){
		$conexao = ConexaoPDO::getConexao();
		$SQL = 'INSERT INTO '.ModuloDAO::$tabela.' (ID_Curso, Nome) VALUES (?, ?) ';
		$stmt = $conexao->prepare($SQL);
		$curso = $curso->converter();



		$stmt->bindParam(1, $curso->id);
		$stmt->bindParam(2, $curso->modulos[0]->nome);

		if(!$stmt->execute()){
			throw new Exception('Erro ao inserir modulo no banco!');
		}
		$modulo = new Modulo($conexao->lastInsertId(), null, $curso->modulos[0]->nome);

		return ['status' => true, 'modulo' => $modulo->converter()];
	}

	public static function consultar($idCurso){
		$conexao = ConexaoPDO::getConexao();
		$SQL = 'SELECT * FROM '.ModuloDAO::$tabela.' WHERE ID_CURSO = ?';
		$stmt = $conexao->prepare($SQL);
		$stmt->bindParam(1, $idCurso);

		if(!$stmt->execute())
            throw new Exception('Erro ao consultar modulo no banco!');

        if($stmt->rowCount() == 0){
        	throw new Exception('Nao exite modulo!');
        }else{
        	$modulos = Array();
			$coluna = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach ($coluna as $chave => $valor){
			$licoes = ControleLicao::consultar($valor['ID']);
			if(!$licoes['status'])
				throw new Exception('Erro ao consultar lições do modulo!');
			$licoes = $licoes['licoes'];
			
			$modulo = new Modulo($valor['ID'], $licoes, $valor['Nome']);
			array_push($modulos, $modulo->converter());
		}
        }
        return ['status' => true, 'modulos' => $modulos];
	}

	public static function consultarUm($id/*Modulo*/){
		$conexao = ConexaoPDO::getConexao();
		$SQL = 'SELECT * FROM '.ModuloDAO::$tabela.' WHERE ID = ?';

		$stmt = $conexao->prepare($SQL);
		$stmt->bindParam(1, $id);

		if(!$stmt->execute())
            throw new Exception('Erro ao consultar modulo no banco!');
        if($stmt->rowCount() < 1)
            throw new Exception('Nenhum modulo registrado!');

        $coluna = $stmt->fetch(PDO::FETCH_ASSOC);

		$licoesR = ControleLicao::consultar($coluna['ID'])['licoes'];
		$licoes = Array();
		foreach ($licoesR as $chave => $licao) {
			$licao = new Licao($licao->id, $licao->nome, $licao->conteudo);
			array_push($licoes, $licao);
		}
		$modulo = new Modulo($coluna['ID'], $licoes, $coluna['Nome']);  
    	return ['status' => true, 'modulo' => $modulo];
	}

	public static function deletar(){

	}

	public static function atualizar(Modulo $modulo){
		$conexao = ConexaoPDO::getConexao();
		$SQL = 'UPDATE '.ModuloDAO::$tabela.' SET Nome = ? WHERE ID = ?';
		$stmt = $conexao->prepare($SQL);
		$modulo = $modulo->converter();

		$stmt->bindParam(1, $modulo->nome);
		$stmt->bindParam(2, $modulo->id);

		if(!$stmt->execute())
			throw new Exception('Erro ao atualizar modulo no banco!');

		return ['status' => true];			
	}
	
}