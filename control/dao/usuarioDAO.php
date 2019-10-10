<?php
include_once '../connect/conexao.php';
include_once '../model/usuario.php';

abstract class UsuarioDAO{
    public static $tabela = 'usuario';

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
            throw new Exception('Erro ao inserir no banco!');
        }
        return ['status' => true];
    }

    public static function consultar(){
        $conexao = ConexaoPDO::getConexao();
        $SQL = "SELECT ID, Data_Nascimento, Tipo, Email, Nome, Sobrenome, Instituicao, Imagem, Biografia FROM ".UsuarioDAO::$tabela;

        $stmt = $conexao->prepare($SQL);

        if(!$stmt->execute()){
            throw new Exception('Erro ao consultar o banco!');
        }
        if($stmt->rowCount() < 1){
            throw new Exception('Nenhum usuario registrado!');
        }

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
        
        if(!$stmt->execute()){
            throw new Exception('Erro ao consultar o banco!');
        }
        if($stmt->rowCount() < 1){
            throw new Exception('Usuario não encontrado!');
        }

        $coluna = $stmt->fetch(PDO::FETCH_ASSOC);
        $usuario = new Usuario($coluna['ID'], $coluna['Data_Nascimento'], $coluna['Tipo'], $coluna['Email'], null, $coluna['Nome'], $coluna['Sobrenome'], $coluna['Instituicao'], $coluna['Imagem'], $coluna['Biografia']);
        return ['status' => true, 'usuario' => $usuario->converter()];
    }

    public static function deletar($id){
        $conexao = ConexaoPDO::getConexao();
        $SQL = "DELETE FROM usuario WHERE id = ?";
        $stmt = $conexao->prepare($SQL);

        $stmt->bindParam(1, $id);

        if(!$stmt->execute()){
            throw new Exception('Erro ao deletar do banco!');
        }

        return ['status' => true];
    }
}