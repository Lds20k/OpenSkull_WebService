<?php
require_once(__DIR__ . '/../../connect/conexao.php');
require_once(__DIR__ . '/../../model/curso.php');
require_once(__DIR__ . '/../../model/modulo.php');
require_once(__DIR__ . '/../controleUsuario.php');
//include_once '../control/controleModulo.php';

abstract class CursoDAO{
	public static $tabela = 'curso';

	public static function verificarCriador($curso){
		$conexao = ConexaoPDO::getConexao();
		$SQL = 'SELECT ID FROM '.CursoDAO::$tabela.' WHERE ID = ? AND Criador = ?';
		$curso = $curso->converter();
		$stmt = $conexao->prepare($SQL);
		$stmt->bindParam(1, $curso->id);
		$stmt->bindParam(2, $curso->criador->id);
		if(!$stmt->execute()){
			throw new Exception('Erro ao consultar no banco!');
		}
		if($stmt->rowCount() < 1){
            throw new Exception('Não tem permição para isto!');
		}
		return true;
	}

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
				
		$curso = new Curso($conexao->lastInsertId(), null, $curso->nome, $curso->imagem, $curso->horas, $curso->descricao, $curso->preco, null);
		return ['status' => true, 'curso' => $curso->converter()];
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
			//Procura usuario
			$usuario = ControleUsuario::consultarUm($valor['Criador']);
			if(!$usuario['status']){
				throw new Exception('Usuario criador do curso não encontrado!');
			}
			$usuario = $usuario['usuario'];
			$criador = new Usuario($usuario->id, $usuario->dataNascimento, $usuario->tipo, $usuario->email, null, $usuario->nome, $usuario->sobrenome, $usuario->instituicao, $usuario->imagem, $usuario->biografia, null);
			$curso  = new Curso($valor['ID'], $criador, $valor['Nome'], $valor['Imagem'], $valor['Horas'], $valor['Descricao'], $valor['Preco'], null);
        	array_push($cursos, $curso->converter());
        }
        return ['status' => true, 'cursos' => $cursos];
	}

	public static function consultarUm($id){
		$conexao = ConexaoPDO::getConexao();
		$SQL = 'SELECT * FROM '.CursoDAO::$tabela.' WHERE ID = ?';
		$stmt = $conexao->prepare($SQL);
		$stmt->bindParam(1, $id);

		if(!$stmt->execute())
			throw new Exception('Erro ao consultar curso no banco!');
        if($stmt->rowCount() < 1)
            throw new Exception('Curso não encontrado!');

		$coluna = $stmt->fetch(PDO::FETCH_ASSOC);

		//Procura usuario
		$usuario = ControleUsuario::consultarUm($coluna['Criador']);
		if(!$usuario['status']){
			throw new Exception('Usuario criador do curso não encontrado!');
		}
       	$usuario = $usuario['usuario'];
        $criador = new Usuario($usuario->id, $usuario->dataNascimento, $usuario->tipo, $usuario->email, null, $usuario->nome, $usuario->sobrenome, $usuario->instituicao, $usuario->imagem, $usuario->biografia);
		
		//Procura modulos
		$modulos = ControleModulo::consultar($coluna['ID']);
		if(!$modulos['status']){
			throw new Exception('Erro no banco ao procurar os modulos do curso!');
		}
		$modulos = $modulos['modulos'];

		//Criar curso
		$curso = new Curso($coluna['ID'], $criador, $coluna['Nome'], $coluna['Imagem'], $coluna['Horas'], $coluna['Descricao'], $coluna['Preco'], $modulos);
		return ['status' => true, 'curso' => $curso->converter()];
	}

	public static function deletar($id){
		$conexao = ConexaoPDO::getConexao();
		$SQL = 'DELETE possui FROM possui INNER JOIN '.CursoDAO::$tabela.' ON possui.ID_Curso = '.CursoDAO::$tabela.'.ID WHERE '.CursoDAO::$tabela.'.ID = ?';
		$stmt = $conexao->prepare($SQL);
		$stmt->bindParam(1, $id);
		if(!$stmt->execute())
			throw new Exception('Erro ao deletar lições no banco!');

		$SQL = 'DELETE '.LicaoDAO::$tabela.' FROM '.LicaoDAO::$tabela.' INNER JOIN '.ModuloDAO::$tabela.' ON '.LicaoDAO::$tabela.'.ID_Modulo = '.ModuloDAO::$tabela.'.ID WHERE '.ModuloDAO::$tabela.'.ID_Curso = ?';
		$stmt = $conexao->prepare($SQL);
		$stmt->bindParam(1, $id);
		if(!$stmt->execute())
			throw new Exception('Erro ao deletar lições no banco!');
		
		$SQL = 'DELETE '.ModuloDAO::$tabela.' FROM '.ModuloDAO::$tabela.' INNER JOIN '.CursoDAO::$tabela.' ON '.ModuloDAO::$tabela.'.ID_Curso = '.CursoDAO::$tabela.'.ID WHERE '.CursoDAO::$tabela.'.ID = ?';
		$stmt = $conexao->prepare($SQL);
		$stmt->bindParam(1, $id);
		if(!$stmt->execute())
			throw new Exception('Erro ao deletar modulos no banco!');

		$SQL = 'DELETE FROM '.CursoDAO::$tabela.' WHERE ID = ?';
		$stmt = $conexao->prepare($SQL);
		$stmt->bindParam(1, $id);
		if(!$stmt->execute())
			throw new Exception('Erro ao deletar curso no banco!');

		return ['status' => true];
	}

	public static function atualizar(Curso $curso){
		$conexao = ConexaoPDO::getConexao();
        function executar($stmt){
            if(!$stmt->execute()){
                echo a;
                return false;
            }
            return true;
        }

        $curso = $curso->converter();
        $condicao = 'WHERE ID = ?';
        if(!is_null($curso->nome)){
            $SQL = 'UPDATE '.CursoDAO::$tabela.' SET Nome = ? ' . $condicao;
            $stmt = $conexao->prepare($SQL);
            $stmt->bindParam(1, $curso->nome);
            $stmt->bindParam(2, $curso->id);
            if(!executar($stmt))
                throw new Exception('Erro ao atualizar o titulo do curso!');
		}
		
		if(!is_null($curso->imagem)){
            $SQL = 'UPDATE '.CursoDAO::$tabela.' SET Imagem = ? ' . $condicao;
            $stmt = $conexao->prepare($SQL);
            $stmt->bindParam(1, $curso->imagem);
            $stmt->bindParam(2, $curso->id);
            if(!executar($stmt))
                throw new Exception('Erro ao atualizar a imagem do curso!');
		}
		
		if(!is_null($curso->horas)){
            $SQL = 'UPDATE '.CursoDAO::$tabela.' SET Horas = ? ' . $condicao;
            $stmt = $conexao->prepare($SQL);
            $stmt->bindParam(1, $curso->horas);
            $stmt->bindParam(2, $curso->id);
            if(!executar($stmt))
                throw new Exception('Erro ao atualizar as horas do curso!');
		}
		
		if(!is_null($curso->descricao)){
            $SQL = 'UPDATE '.CursoDAO::$tabela.' SET Descricao = ? ' . $condicao;
            $stmt = $conexao->prepare($SQL);
            $stmt->bindParam(1, $curso->descricao);
            $stmt->bindParam(2, $curso->id);
            if(!executar($stmt))
                throw new Exception('Erro ao atualizar a descricao do curso!');
		}
		
		if(!is_null($curso->preco)){
            $SQL = 'UPDATE '.CursoDAO::$tabela.' SET Preco = ? ' . $condicao;
            $stmt = $conexao->prepare($SQL);
            $stmt->bindParam(1, $curso->preco);
            $stmt->bindParam(2, $curso->id);
            if(!executar($stmt))
                throw new Exception('Erro ao atualizar o preco do curso!');
		}
		
		return ['status' => true];
	}

	public static function consultarPorUsuario($idUsuario){
		$conexao = ConexaoPDO::getConexao();
		
		$SQL = 'SELECT * FROM '.CursoDAO::$tabela.' WHERE Criador = ?';

		$stmt = $conexao->prepare($SQL);
		$stmt->bindParam(1, $idUsuario);

		if(!$stmt->execute()){
            throw new Exception('Erro ao consultar curso no banco!');
        }
        if($stmt->rowCount() < 1){
            throw new Exception('Nenhum curso registrado!');
        }

        $cursos = Array();
        $coluna = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($coluna as $chave => $valor) {
			//Procura usuario
			$usuario = ControleUsuario::consultarUm($valor['Criador']);
			if(!$usuario['status']){
				throw new Exception('Usuario criador do curso não encontrado!');
			}
			$usuario = $usuario['usuario'];
			$criador = new Usuario($usuario->id, $usuario->dataNascimento, $usuario->tipo, $usuario->email, null, $usuario->nome, $usuario->sobrenome, $usuario->instituicao, $usuario->imagem, $usuario->biografia, null);
			$curso  = new Curso($valor['ID'], $criador, $valor['Nome'], $valor['Imagem'], $valor['Horas'], $valor['Descricao'], $valor['Preco'], null);
        	array_push($cursos, $curso->converter());
        }
        return ['status' => true, 'cursos' => $cursos];
	}
}	