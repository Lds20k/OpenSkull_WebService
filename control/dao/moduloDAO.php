<?php
include_once '../connect/conexao.php'; 
include_once '../model/curso.php';
include_once '../model/modulo.php';

abstract class ModuloDAO{
	public static $tabela = 'modulo';

	public static function inserir(Modulo $modulo){
		$conexao = ConexaoPDO::getConexao();
		$SQL = 'INSERT INTO '.ModuloDAO::$tabela.' (ID_Curso, Nome) VALUES (?, ?) ';
		$stmt = $conexao->prepare($SQL);
		$modulo = $modulo->converter();
		$stmt->bindParam(1, $modulo->curso->id);
		$stmt->bindParam(2, $modulo->nome);

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

        $curso = ControleCurso::consultarUm($idCurso);
		$criador = $curso['curso']->criador;
		$criador = new Usuario($criador->id, $criador->dataNascimento, $criador->tipo, $criador->email, null, $criador->nome, $criador->sobrenome, $criador->instituicao, $criador->imagem, $criador->biografia);
		$curso = $curso['curso'];
		$curso = new Curso($curso->id, $criador, $curso->nome,  $curso->imagem, $curso->horas, $curso->descricao, $curso->preco);
        
		$modulos = Array();
        $coluna = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($coluna as $chave => $valor){
        	$modulo = new Modulo($valor['ID'], $curso, $valor['Nome']);
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

       	$curso = ControleCurso::consultarUm($coluna['ID_Curso']);
       	$curso = $curso['curso'];
       	$criador = $curso->criador;
       	$criador = new Usuario($criador->id, $criador->dataNascimento, $criador->tipo, $criador->email, null, $criador->nome, $criador->sobrenome, $criador->instituicao, $criador->imagem, $criador->biografia);
       	$curso = new Curso($curso->id, $criador, $curso->nome, $curso->imagem, $curso->horas, $curso->descricao, $curso->preco);
       	$modulo = new Modulo($coluna['ID'], $curso, $coluna['Nome']);

       	return ['status' => true, 'modulo' => $modulo->converter()];
	}

	public static function deletar(){

	}

	public static function atualizar(){

	}
}