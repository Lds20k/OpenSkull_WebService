<?php
include_once '../connect/conexao.php';
include_once '../model/usuario.php';

abstract class UsuarioDAO{
    public static $tabela = 'usuario';

    public static function inserir(Usuario $usuario){
        $conexao = ConexaoPDO::getConexao();
        $SQL = 'INSERT INTO '.UsuarioDAO::$tabela.' ( Data_Nascimento,  Tipo,  Email,  Senha,  Nome,  Sobrenome, Instituicao, Imagem, Biografia) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $stmt = $conexao->prepare($SQL);

        $dataNascimento = $usuario->getDataNascimento();
        $stmt->bindParam(1, $dataNascimento);

        $tipo = $usuario->getTipo();
        $stmt->bindParam(2, $tipo);

        $email = $usuario->getEmail();
        $stmt->bindParam(3, $email);

        $senha = $usuario->getSenha();
        $stmt->bindParam(4, $senha);

        $nome = $usuario->getNome();
        $stmt->bindParam(5, $nome);

        $sobrenome = $usuario->getSobrenome();
        $stmt->bindParam(6, $sobrenome);

        $instituicao = $usuario->getInstituicao();
        $stmt->bindParam(7, $instituicao);

        $imagem = $usuario->getImagem();
        $stmt->bindParam(8, $imagem);

        $biografia = $usuario->getBiografia();
        $stmt->bindParam(9, $biografia);

        if(!$stmt->execute()){
            return ['status' => false];
        }
        return ['status' => true];
    }
}