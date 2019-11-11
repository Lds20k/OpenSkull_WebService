<?php
require_once(__DIR__ . '/../../model/licao.php');
require_once(__DIR__ . '/../../connect/conexao.php');

abstract class LicaoDAO{
	public static $tabela = 'licao';

	public static function inserir(Modulo $modulo){
		$conexao = ConexaoPDO::getConexao();
		$SQL	 = 'INSERT INTO '.LicaoDAO::$tabela.' (ID_Modulo, Nome, Conteudo, Video) VALUES (?, ?, ?, ?)';
		$stmt	 = $conexao->prepare($SQL);
		$modulo  = $modulo->converter();
		$licao   = $modulo->licoes[0];

		$stmt->bindParam(1, $modulo->id);
		$stmt->bindParam(2, $licao->nome);
		$stmt->bindParam(3, $licao->conteudo);
		$stmt->bindParam(4, $licao->video);
        if(!$stmt->execute()){
            throw new Exception('Erro ao inserir usuario no banco!');
		}
		$licao->id = $conexao->lastInsertId();
        return ['status' => true, 'licao' => $licao];
	}
	
	public static function atualizar(){

	}
	
	public static function consultar($idModulo){
		$conexao = ConexaoPDO::getConexao();
		$SQL = 'SELECT * FROM '.LicaoDAO::$tabela.' WHERE ID_Modulo = ?';
		
		$stmt = $conexao->prepare($SQL);
		$stmt->bindParam(1, $idModulo);

		if(!$stmt->execute())
			throw new Exception('Erro ao consultar lição no banco!');
			
        $licoes = Array();
        $coluna = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($coluna as $chave => $valor) {
         	$licao = new Licao($valor['ID'], $valor['Nome'], $valor['Conteudo']);
         	array_push($licoes, $licao->converter());
        }
        return ['status' => true, 'licoes' => $licoes];
	}
	
	public static function consultarUm($id){
		$conexao = ConexaoPDO::getConexao();
		$SQL = 'SELECT * FROM '.LicaoDAO::$tabela.' WHERE ID = ?';
		$stmt = $conexao->prepare($SQL);

		$stmt->bindParam(1, $id);

		if(!$stmt->execute())
            throw new Exception('Erro ao consultar modulo no banco!');
        if($stmt->rowCount() < 1)
            throw new Exception('Nenhum modulo registrado!');

        $coluna = $stmt->fetch(PDO::FETCH_ASSOC);

        $licao = new Licao($coluna['ID'], $coluna['Nome'], $coluna['Conteudo']);
        $licao = $licao->converter();

        return ['status' => true, 'licao' => $licao];
	}
	
	public static function deletar($id){
		
	}
}