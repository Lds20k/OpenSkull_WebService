<?php
include_once 'controle.php';
include_once 'dao/usuarioDAO.php';
include_once '../model/usuario.php';


abstract class ControleUsuario{

    public static function inserir($args){
        try {
            if(!isset($args['instituicao'])){
                $args['instituicao'] = null;
            }

            if(!isset($args['imagem'])){
                $args['imagem'] = null;
            }

            if(!isset($args['biografia'])){
                $args['biografia'] = null;
            }

            if(sizeof($args) == 8){
                $args = (object)$args;
                $usuario = new Usuario(null, $args->dataNascimento, 'c', $args->email, $args->senha, $args->nome, $args->sobrenome, $args->instituicao, $args->imagem, $args->biografia);
                $resposta = UsuarioDAO::inserir($usuario);
            }else{
                $resposta = ['status' => false];
            }
            
        } catch (Exception $ex) {
            $resposta = ['status' => false];
        }
        return $resposta;
    }

    public static function consultar(){
        try{
            $resposta = UsuarioDAO::consultar();
        }catch(Exception $ex){
            return ['status' => false];
        }
        return $resposta;
    }

    public static function consultarUm($key){
        try{
            $resposta = UsuarioDAO::consultarUm($key);
        }catch(Exception $ex){
            $resposta = ['status' => false];
        }
        return $resposta;
     }

    public static function deletar($id){
        try{
            $resposta = UsuarioDAO::deletar($id);
        }catch(Exception $ex){
            $resposta = ['status' => false];
        }
        return $resposta;
    }

    public static function jwt($args){
        try{
            $resposta = UsuarioDAO::jwt($args['email'], $args['senha']);
        }catch(Exception $ex){
            $resposta = ['status' => false];
        }
        return $resposta;
    }
}