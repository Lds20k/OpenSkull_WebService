<?php
require_once(__DIR__ . '/../../connect/conexao.php');
require_once(__DIR__ . '/../../model/usuario.php');
require_once(__DIR__ . '/../../model/jwt.php');

abstract class UsuarioDAO{
    public static $tabela = 'usuario';
    public static $tabelaPossui = 'possui';

    public static function inserir(Usuario $usuario){
        $conexao = ConexaoPDO::getConexao();
        $SQL = 'INSERT INTO '.UsuarioDAO::$tabela.' ( Data_Nascimento,  Tipo,  Email,  Senha,  Nome,  Sobrenome, Instituicao, Imagem, Biografia) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $stmt = $conexao->prepare($SQL);

        $usuario = $usuario->converter(true);
        $stmt->bindParam(1, $usuario->dataNascimento);
        $stmt->bindParam(2, $usuario->tipo);
        $stmt->bindParam(3, $usuario->email);
        $usuario->senha = password_hash($usuario->senha, PASSWORD_DEFAULT);
        $stmt->bindParam(4, $usuario->senha);
        $stmt->bindParam(5, $usuario->nome);
        $stmt->bindParam(6, $usuario->sobrenome);
        $stmt->bindParam(7, $usuario->instituicao);
        $stmt->bindParam(8, $usuario->imagem);
        $stmt->bindParam(9, $usuario->biografia);

        if(!$stmt->execute()){
            throw new Exception('Erro ao inserir usuario no banco!');
        }
        return ['status' => true];
    }

    public static function consultar(){
        $conexao = ConexaoPDO::getConexao();
        $SQL = 'SELECT ID, Data_Nascimento, Tipo, Email, Nome, Sobrenome, Instituicao, Imagem, Biografia FROM '.UsuarioDAO::$tabela;

        $stmt = $conexao->prepare($SQL);

        if(!$stmt->execute())
            throw new Exception('Erro ao consultar usuario no banco!');
        if($stmt->rowCount() < 1)
            throw new Exception('Nenhum usuario registrado!');

        $usuarios = Array();
        $coluna = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($coluna as $chave => $valor) {
            $usuario = new Usuario($valor['ID'], $valor['Data_Nascimento'], $valor['Tipo'], $valor['Email'], null, $valor['Nome'], $valor['Sobrenome'], $valor['Instituicao'], $valor['Imagem'], $valor['Biografia']);
            array_push($usuarios, $usuario->converter());
        }

        return ['status' => true, 'usuarios' => $usuarios];
    }

    public static function consultarUm($key){
        $conexao = ConexaoPDO::getConexao();
        $SQL = 'SELECT ID, Data_Nascimento, Tipo, Email, Nome, Sobrenome, Instituicao, Imagem, Biografia FROM '.UsuarioDAO::$tabela.' WHERE ';
        
        if(is_numeric($key)){
            $SQL .= 'ID = ?';
        }else{
            $SQL .= 'Email = ?';
        }

        $stmt= $conexao->prepare($SQL);

        $stmt->bindParam(1, $key);
        
        if(!$stmt->execute())
            throw new Exception('Erro ao consultar usuario no banco!');
        if($stmt->rowCount() < 1)
            throw new Exception('Usuario não encontrado!');

        $coluna = $stmt->fetch(PDO::FETCH_ASSOC);
        $usuario = new Usuario($coluna['ID'], $coluna['Data_Nascimento'], $coluna['Tipo'], $coluna['Email'], null, $coluna['Nome'], $coluna['Sobrenome'], $coluna['Instituicao'], $coluna['Imagem'], $coluna['Biografia']);
        return ['status' => true, 'usuario' => $usuario->converter()];
    }

    public static function deletar($id){
        $conexao = ConexaoPDO::getConexao();
        $SQL = 'DELETE FROM usuario WHERE id = ?';
        $stmt = $conexao->prepare($SQL);

        $stmt->bindParam(1, $id);

        if(!$stmt->execute())
            throw new Exception('Erro ao deletar usuario do banco!');

        return ['status' => true];
    }

    public static function getJWT($email, $senha){
        $conexao = ConexaoPDO::getConexao();
        $SQL = 'SELECT ID, Senha FROM '.UsuarioDAO::$tabela.' WHERE Email = ?';
        $stmt = $conexao->prepare($SQL);

        $stmt->bindParam(1, $email);

        if(!$stmt->execute())
            throw new Exception('Erro ao consultar usuario do banco!');
        if($stmt->rowCount() < 1)
            throw new Exception('Usuario não encontrado!');

        $coluna = $stmt->fetch(PDO::FETCH_ASSOC);
        if(password_verify($senha, $coluna['Senha']))
            $jwt = OpenSkullJWT::codificar(['id' => $coluna['ID'], 'email' => $email]);
        else
            throw new Exception('Senha incorreta!');

        return ['status' => true, 'jwt' => $jwt];
    }

    public static function atualizar(Usuario $usuario){
        $conexao = ConexaoPDO::getConexao();
        function executar($stmt){
            if(!$stmt->execute()){
                echo a;
                return false;
            }
            return true;
        }

        $usuario = $usuario->converter(true);
        $condicao = 'WHERE ID = ?';
        if(!is_null($usuario->dataNascimento)){
            $SQL = 'UPDATE '.UsuarioDAO::$tabela.' SET Data_Nascimento = ? ' . $condicao;
            $stmt = $conexao->prepare($SQL);
            $stmt->bindParam(1, $usuario->dataNascimento);
            $stmt->bindParam(2, $usuario->id);
            if(!executar($stmt))
                throw new Exception('Erro ao atualizar a data de nascimento do usuario!');
        }

        if(!is_null($usuario->tipo) and $usuario->tipo != ''){
            $SQL = 'UPDATE '.UsuarioDAO::$tabela.' SET Tipo = ? ' . $condicao;
            $stmt = $conexao->prepare($SQL);
            $stmt->bindParam(1, $usuario->tipo);
            $stmt->bindParam(2, $usuario->id);
            if(!executar($stmt))
                throw new Exception('Erro ao atualizar o tipo de conta do usuario!');
        }

        if(!is_null($usuario->email) and $usuario->email != ''){
            $SQL = 'UPDATE '.UsuarioDAO::$tabela.' SET Email = ? ' . $condicao;
            $stmt = $conexao->prepare($SQL);
            $stmt->bindParam(1, $usuario->email);
            $stmt->bindParam(2, $usuario->id);
            if(!executar($stmt))
                throw new Exception('Erro ao atualizar o email do usuario!');
        }

        if(!is_null($usuario->senha) and $usuario->senha != ''){
            $SQL = 'UPDATE '.UsuarioDAO::$tabela.' SET Senha = ? ' . $condicao;
            $stmt = $conexao->prepare($SQL);
            $usuario->senha = password_hash($usuario->senha, PASSWORD_DEFAULT);
            $stmt->bindParam(1, $usuario->senha);
            $stmt->bindParam(2, $usuario->id);
            if(!executar($stmt))
                throw new Exception('Erro ao atualizar a senha do usuario!');
        }

        if(!is_null($usuario->nome) and $usuario->nome != ''){
            $SQL = 'UPDATE '.UsuarioDAO::$tabela.' SET Nome = ? ' . $condicao;
            $stmt = $conexao->prepare($SQL);
            $stmt->bindParam(1, $usuario->nome);
            $stmt->bindParam(2, $usuario->id);
            if(!executar($stmt))
                throw new Exception('Erro ao atualizar o nome do usuario!');
        }

        if(!is_null($usuario->sobrenome) and $usuario->sobrenome != ''){
            $SQL = 'UPDATE '.UsuarioDAO::$tabela.' SET Sobrenome = ? ' . $condicao;
            $stmt = $conexao->prepare($SQL);
            $stmt->bindParam(1, $usuario->sobrenome);
            $stmt->bindParam(2, $usuario->id);
            if(!executar($stmt))
                throw new Exception('Erro ao atualizar o sobrenome do usuario!');
        }

        $SQL = 'UPDATE '.UsuarioDAO::$tabela.' SET Instituicao = ? ' . $condicao;
        $stmt = $conexao->prepare($SQL);
        $stmt->bindParam(1, $usuario->instituicao);
        $stmt->bindParam(2, $usuario->id);
        if(!executar($stmt))
            throw new Exception('Erro ao atualizar a instituicao do usuario!');

        $SQL = 'UPDATE '.UsuarioDAO::$tabela.' SET Imagem = ? ' . $condicao;
        $stmt = $conexao->prepare($SQL);
        $stmt->bindParam(1, $usuario->imagem);
        $stmt->bindParam(2, $usuario->id);
        if(!executar($stmt))
            throw new Exception('Erro ao atualizar a imagem do usuario!');

        $SQL = 'UPDATE '.UsuarioDAO::$tabela.' SET Biografia = ? ' . $condicao;
        $stmt = $conexao->prepare($SQL);
        $stmt->bindParam(1, $usuario->biografia);
        $stmt->bindParam(2, $usuario->id);
        if(!executar($stmt))
            throw new Exception('Erro ao atualizar a biografia do usuario!');

        return ['status' => true];
    }

    public static function adicionarCurso(Usuario $usuario, Curso $curso){
        $conexao = ConexaoPDO::getConexao();
        $SQL     = 'INSERT INTO possui (ID_Usuario, ID_Curso, Ativado) VALUES (?, ?, ?)';
        $stmt    = $conexao->prepare($SQL);
        $usuario = $usuario->converter();
        $curso   = $curso->converter();


        $stmt->bindParam(1, $usuario->id);
        $stmt->bindParam(2, $curso->id);
        $ativado = ($curso->preco > 0) ? 0 : 1;
        $stmt->bindParam(3, $ativado);

        if(!$stmt->execute())
            throw new Exception('Erro ao fazer relacionamento em possui!');

        return ['status' => true];
    }

    public static function desativados(){
        $conexao = ConexaoPDO::getConexao();
        $SQL = 'SELECT * FROM possui WHERE Ativado = 0';
        $stmt = $conexao->prepare($SQL);

        if(!$stmt->execute())
            throw new Exception('Erro ao pesquisar no banco!');

        $possui = new stdClass();
        $coluna = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $possui = Array();
        foreach ($coluna as $chave => $valor) {
            $conteudo = new stdClass();
            $conteudo->id_curso = $valor['ID_Curso'];
            $conteudo->id_usuario = $valor['ID_Usuario'];
            $conteudo->ativado = $valor['Ativado'];
            array_push($possui, $conteudo);
        }
		return ['status' => true, 'possui' => $possui];
    }
    
    public static function ativar($usuario, $curso){
        $conexao = ConexaoPDO::getConexao();
        $SQL = 'UPDATE possui SET Ativado = 1 WHERE ID_Usuario = ? AND ID_Curso = ?';
        $stmt = $conexao->prepare($SQL);
        
        $stmt->bindParam(1, $usuario);
        $stmt->bindParam(2, $curso);

        if(!$stmt->execute())
            throw new Exception('Erro ao atualizar no banco!');

        

        return ['status' => true];
	}

    public static function consultarCursos($key){
        $conexao = ConexaoPDO::getConexao();
        $SQL = 'SELECT '.CursoDAO::$tabela.'.*, '.UsuarioDAO::$tabelaPossui.'.Ativado FROM '.UsuarioDAO::$tabelaPossui.' INNER JOIN '.CursoDAO::$tabela.' ON possui.ID_Curso = curso.ID WHERE possui.ID_Usuario = ?';
        
		$stmt = $conexao->prepare($SQL);
		$stmt->bindParam(1, $key);

		if(!$stmt->execute())
			throw new Exception('Erro ao consultar curso no banco!');
        if($stmt->rowCount() < 1)
            throw new Exception('Curso não encontrado!');

		$coluna = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $cursos = Array();
        foreach ($coluna as $chave => $valor) {
			//Procura usuario
			$usuario = ControleUsuario::consultarUm($valor['Criador']);
			if(!$usuario['status']){
				throw new Exception('Usuario criador do curso não encontrado!');
			}
			$usuario = $usuario['usuario'];
			$criador = new Usuario($usuario->id, $usuario->dataNascimento, $usuario->tipo, $usuario->email, null, $usuario->nome, $usuario->sobrenome, $usuario->instituicao, $usuario->imagem, $usuario->biografia, null);
            $curso   = new Curso($valor['ID'], $criador, $valor['Nome'], $valor['Imagem'], $valor['Horas'], $valor['Descricao'], $valor['Preco'], null);
            $curso   = $curso->converter();
            $curso->ativado = $valor['Ativado'] ? true : false;
        	array_push($cursos, $curso);
        }
		return ['status' => true, 'cursos' => $cursos];
    }
}