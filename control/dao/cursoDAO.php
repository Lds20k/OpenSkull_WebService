<?php
include_once '../connect/conexao.php';
include_once '../model/curso.php';

abstract class CursoDAO{
	private static $tabela = 'Curso';

	public static function inserir(Curso $curso){
		$conexao = ConexaoPDO::getConexao();
		$SQL = 'INSERT INTO '.CursoDAO::$tabela.' (Criador, Nome, Imagem, Horas, Descricao, Preco) 
							 VALUES (?, ?, ?, ?, ?, ?)';
		$curso = $curso->converter();
		$stmt = $conexao->prepare($SQL);
		$stmt->bindParam(1, $curso->$criador->id);
		$stmt->bindParam(2, $curso->nome);
		$stmt->bindParam(3, $curso->imagem);
		$stmt->bindParam(4, $curso->horas);
		$stmt->bindParam(5, $curso->descricao);
		$stmt->bindParam(6, $curso->preco);

		if(!$stmt->execute()){
			throw new Exception('Erro ao inserir no banco!');
		}
		return ['status' => true];
	}
}