<?php
include_once '../model/licao.php';
include_once '../connect/conexao.php';

abstract class LicaoDAO{
	public static $tabela = 'licao';

	public static function inserir(Licao $licao){
		$conexao = ConexaoPDO::getConexao();
		$SQL = 'INSERT INTO '.LicaoDAO::$tabela.' (ID_Modulo, Nome, Conteudo) VALUES (?, ?, ?)';
		$stmt = $conexao->prepare($SQL);

		$licao = $licao->converter();

		$stmt->bindParam(1, $licao->modulo->id);
		$stmt->bindParam(2, $licao->nome);
		$stmt->bindParam(3, $licao->conteudo);

        if(!$stmt->execute()){
            throw new Exception('Erro ao inserir usuario no banco!');
        }
        return ['status' => true];
	}
	
	public static function atualizar(){

	}
	
	public static function consultar($idModulo){

	}
	
	public static function consultarUm($idLicao){

	}
	
	public static function deletar($id){
		
	}
}