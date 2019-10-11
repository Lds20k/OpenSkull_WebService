<?php
include_once 'controle.php';
include_once 'dao/usuarioDAO.php';
include_once '../model/usuario.php';
include_once '../model/jwt.php';

abstract class ControleUsuario{

    public static function inserir($args){
        try {
            if(!isset($args['instituicao']) or $args['instituicao'] == ''){
                $args['instituicao'] = null;
            }

            if(!isset($args['imagem']) or $args['imagem'] == ''){
                $args['imagem'] = null;
            }

            if(!isset($args['biografia']) or $args['biografia'] == ''){
                $args['biografia'] = null;
            }

            if(sizeof($args) == 8){
                $args = (object)$args;
                $usuario = new Usuario(
                    null, //ID
                    $args->dataNascimento, 
                    'c',  //Tipo
                    $args->email, 
                    $args->senha, 
                    $args->nome, 
                    $args->sobrenome, 
                    $args->instituicao, 
                    $args->imagem, 
                    $args->biografia
                );
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
            if(OpenSkullJWT::verificar($key)){
                $key = OpenSkullJWT::decodificar($key)->dados->id;
            }
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

    public static function getJWT($args){
        try{
            $resposta = UsuarioDAO::getJWT($args['email'], $args['senha']);
        }catch(Exception $ex){
            $resposta = ['status' => false];
        }
        return $resposta;
    }

    public static function atualizar($jwt, $args){
        try{
            $args = (object)$args;
            $usuario = new Usuario(
                OpenSkullJWT::decodificar($jwt)->dados->id, 
                (isset($args->dataNascimento)) ? $args->dataNascimento : null, 
                (isset($args->tipo          )) ? $args->tipo           : null, 
                (isset($args->email         )) ? $args->email          : null, 
                (isset($args->senha         )) ? $args->senha          : null, 
                (isset($args->nome          )) ? $args->nome           : null, 
                (isset($args->sobrenome     )) ? $args->sobrenome      : null, 
                (isset($args->instituicao   ) and $args->instituicao != '') ? $args->instituicao : null, 
                (isset($args->imagem        ) and $args->imagem      != '') ? $args->imagem      : null, 
                (isset($args->biografia     ) and $args->biografia   != '') ? $args->biografia   : null
            );
            $resposta = UsuarioDAO::atualizar($usuario);
        }catch(Exception $ex){
            $resposta = ['status' => false];
        }
        return $resposta;
    }
}