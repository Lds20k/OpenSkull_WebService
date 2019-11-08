<?php
require_once(__DIR__ . '/../../connect/conexao.php');
require_once(__DIR__ . '/../../model/curso.php');
require_once(__DIR__ . '/../../model/modulo.php');
require_once(__DIR__ . '/../../model/licao.php');

abstract class ModuloDAO{
	public static $tabela = 'modulo';

	public static function inserir(Curso $curso){
		$conexao = ConexaoPDO::getConexao();
		$SQL = 'INSERT INTO '.ModuloDAO::$tabela.' (ID_Curso, Nome) VALUES (?, ?) ';
		$stmt = $conexao->prepare($SQL);
		$curso->converter();

		$stmt->bindParam(1, $curso->id);
		$stmt->bindParam(2, $curso->modulo[0]->nome);

		if(!$stmt->execute()){
			throw new Exception('Erro ao inserir modulo no banco!');
		}
		$modulo = new Modulo($conexao->lastInsertId(), null, $args->nome);

		return ['status' => true, 'modulo' => $modulo->converter()];
	}

	public static function consultar($idCurso){
		$conexao = ConexaoPDO::getConexao();
		$SQL = 'SELECT * FROM '.ModuloDAO::$tabela.' WHERE ID_CURSO = ?';
		$stmt = $conexao->prepare($SQL);
		$stmt->bindParam(1, $idCurso);

		if(!$stmt->execute())
            throw new Exception('Erro ao consultar modulo no banco!');

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

        $licao = ControleLicao::consultar($coluna['ID']);

        $modulos = Array();
        if($licao['status'] == true){
        	$licao = $licao['licoes'];
	        foreach ($licao as $chave => $valor) {
		        $licao = new Licao($valor->id, $valor->nome, $valor->conteudo);
		        $modulo = new Modulo($coluna['ID'], $licao, $coluna['Nome']);  
		        array_push($modulos, $modulo->converter());
		    }
		}else{
	        $licao = new Licao(null, null, null);
	        $modulo = new Modulo($coluna['ID'], $licao, $coluna['Nome']);
	  	}
    	return ['status' => true, 'modulo' => $modulos];
	}

	public static function deletar(){

	}

	public static function atualizar(){

	}
}