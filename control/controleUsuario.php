<?php
include_once 'controle.php';
include_once 'dao/usuarioDAO.php';
include_once '../model/usuario.php';

abstract class ControleUsuario{

    protected static function converter(Usuario $usuario){
        $usuarioJson                 = new stdClass;
        $usuarioJson->id             = $usuario->getId();
        $usuarioJson->dataNascimento = $usuario->getDataNascimento();
        $usuarioJson->tipo           = $usuario->getTipo();
        $usuarioJson->email          = $usuario->getEmail();
        $usuarioJson->senha          = $usuario->getSenha();
        $usuarioJson->nome           = $usuario->getNome();
        $usuarioJson->sobrenome      = $usuario->getSobrenome();
        $usuarioJson->instituicao    = $usuario->getInstituicao();
        $usuarioJson->imagem         = $usuario->getImagem();
        $usuarioJson->biografia      = $usuario->getBiografia();
        return $usuarioJson;
    }

    public static function inserir($dataNascimento, $tipo = null, $email = null, $senha = null, $nome = null, $sobrenome = null, $instituicao = null, $imagem = null, $biografia = null){
        try {
            $usuario = new Usuario(null, $dataNascimento, $tipo, $email, $senha, $nome, $sobrenome, $instituicao, $imagem, $biografia);
            echo $dataNascimento;
        } catch (Throwable $th) {
            
        }
        
        return ControleUsuario::converter($usuario);
    }
}