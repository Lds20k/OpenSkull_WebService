<?php
include_once '../connect/conexao.php'; 
include_once '../model/curso.php';
include_once '../model/modulo.php';
include_once '../model/licao.php';

abstract class ModuloDAO{
	public static $tabela = 'modulo';

	public static function inserir($args){
		$conexao = ConexaoPDO::getConexao();
		$SQL = 'INSERT INTO '.ModuloDAO::$tabela.' (ID_Curso, Nome) VALUES (?, ?) ';
		$stmt = $conexao->prepare($SQL);

		$stmt->bindParam(1, $args->idCurso);
		$stmt->bindParam(2, $args->nome);

		if(!$stmt->execute()){
			throw new Exception('Erro ao inserir modulo no banco!');
		}

		return ['status' => true];
	}

	public static function consultar($idCurso){
		$conexao = ConexaoPDO::getConexao();
		$SQL = 'SELECT * FROM '.ModuloDAO::$tabela.' WHERE ID_CURSO = ?';
		$stmt = $conexao->prepare($SQL);
		$stmt->bindParam(1, $idCurso);

		if(!$stmt->execute())
            throw new Exception('Erro ao consultar modulo no banco!');
        if($stmt->rowCount() < 1)
            throw new Exception('Nenhum modulo registrado!');
        
		$modulos = Array();
        $coluna = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($coluna as $chave => $valor){
        	$licao = ControleLicao::consultar($valor['ID']);
        	if($licao['status'] == true){
        		$licao = $licao['licoes'];
	        	foreach ($licao as $key => $value) {
	        		$licao = new Licao($value->id, $value->nome, $value->conteudo);
	        		$modulo = new Modulo($valor['ID'], $licao, $valor['Nome']);
	        		array_push($modulos, $modulo->converter());
	        	}
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