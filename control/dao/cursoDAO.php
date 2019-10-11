<?php
include_once '../connect/conexao.php';
include_once '../model/curso.php';
include_once '../control/controleUsuario.php';

abstract class CursoDAO{
	private static $tabela = 'curso';

	public static function inserir(Curso $curso){
		$conexao = ConexaoPDO::getConexao();
		$SQL = 'INSERT INTO '.CursoDAO::$tabela.' (Criador, Nome, Imagem, Horas, Descricao, Preco) 
							 VALUES (?, ?, ?, ?, ?, ?)';
		$curso = $curso->converter();
		$stmt = $conexao->prepare($SQL);
		$stmt->bindParam(1, $curso->criador->id);
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

	public static function consultar(){
		$conexao = ConexaoPDO::getConexao();
		$SQL = 'SELECT * FROM '.CursoDAO::$tabela;

		$stmt = $conexao->prepare($SQL);

		if(!$stmt->execute()){
            throw new Exception('Erro ao consultar curso no banco!');
        }
        if($stmt->rowCount() < 1){
            throw new Exception('Nenhum curso registrado!');
        }

        $cursos = Array();
        $coluna = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($coluna as $chave => $valor) {
        	$criador =  ControleUsuario::consultarUm($valor['Criador']);
        	$criador =  $criador['usuario'];
        	$criador = new Usuario($criador->id, $criador->dataNascimento, $criador->tipo, $criador->email, null, $criador->nome, $criador->sobrenome, $criador->instituicao, $criador->imagem, $criador->biografia);

        	$curso = new Curso($valor['ID'], $criador, $valor['Nome'], $valor['Imagem'], $valor['Horas'], $valor['Descricao'], $valor['Preco']);
        	array_push($cursos, $curso->converter());
        }
        return ['status' => true, 'cursos' => $cursos];
	}

	public static function consultarUm($id){
		$conexao = ConexaoPDO::getConexao();
		$SQL = 'SELECT * FROM curso WHERE ID = ?';
		$stmt = $conexao->prepare($SQL);
		$stmt->bindParam(1, $id);

		if(!$stmt->execute())
			throw new Exception('Erro ao consultar curso no banco!');
        if($stmt->rowCount() < 1)
            throw new Exception('Curso não encontrado!');

		$coluna = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		$cursos = Array();
        foreach ($coluna as $chave => $valor) {
	        $criador =  ControleUsuario::consultarUm($valor['Criador']);
        	$criador =  $criador['usuario'];
        	$criador = new Usuario($criador->id, $criador->dataNascimento, $criador->tipo, $criador->email, null, $criador->nome, $criador->sobrenome, $criador->instituicao, $criador->imagem, $criador->biografia);
        	$curso = new Curso($valor['ID'], $criador, $valor['Nome'], $valor['Imagem'], $valor['Horas'], $valor['Descricao'], $valor['Preco']);
        	array_push($cursos, $curso->converter());
        }    
		return ['status' => true, 'cursos' => $cursos];
	}

	public static function deletar($id){
		$conexao = ConexaoPDO::getConexao();
		$SQL = 'DELETE FROM curso WHERE ID = ?';

		$stmt = $conexao->prepare($SQL);
		$stmt->bindParam(1, $id);

		if(!$stmt->execute())
			throw new Exception('Erro ao deletar curso no banco!');

		return ['status' => true];
	}
}	