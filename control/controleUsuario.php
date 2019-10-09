<?php
include_once 'controle.php';
include_once 'dao/usuarioDAO.php';
include_once '../model/usuario.php';
include_once '../connect/conexao.php';


abstract class ControleUsuario{

    protected static function converter(Usuario $usuario){
        $usuarioJson                 = new stdClass;
        $usuarioJson->id             = $usuario->getId();
        $usuarioJson->dataNascimento = $usuario->getDataNascimento();
        $usuarioJson->tipo           = $usuario->getTipo();
        $usuarioJson->email          = $usuario->getEmail();
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

    public static function consultar(){
        try{
            $conexao = ConexaoPDO::getConexao();
            $sql = "SELECT ID, Data_Nascimento, Tipo, Email, Nome, Sobrenome, Instituicao, Imagem, Biografia FROM usuario";

            $stmt = $conexao->prepare($sql);

            $usuarios = Array();
            if($stmt->execute()){
                $coluna = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($coluna as $chave => $valor) {
                    $usuario = new Usuario($valor['ID'], $valor['Data_Nascimento'], $valor['Tipo'], $valor['Email'], null, $valor['Nome'], $valor['Sobrenome'], $valor['Instituicao'], $valor['Imagem'], $valor['Biografia']);

                    $converterUser = ControleUsuario::converter($usuario);

                    array_push($usuarios, $converterUser);
                }        
            }
        }catch(Exception $ex){

        }

        return $usuarios;
    }

    public static function consultarUm($id){
        try{
            $conexao = ConexaoPDO::getConexao();
            $sql = "SELECT ID, Data_Nascimento, Tipo, Email, Nome, Sobrenome, Instituicao, Imagem, Biografia FROM usuario WHERE ID = ?";

            $stmt= $conexao->prepare($sql);

            $stmt->bindParam(1, $id);

            $usuarios = Array();
            if($stmt->execute()){
                $coluna = $stmt->fetch(PDO::FETCH_ASSOC);
                
                $usuario = new Usuario($coluna['ID'], $coluna['Data_Nascimento'], $coluna['Tipo'], $coluna['Email'], null, $coluna['Nome'], $coluna['Sobrenome'], $coluna['Instituicao'], $coluna['Imagem'], $coluna['Biografia']);

                $converterUser = ControleUsuario::converter($usuario);

                array_push($usuarios, $converterUser);
            }
            return $usuarios;
        }catch(Exception $ex){

        }
     }

    public static function deletar($id){
        try{
            $conexao = ConexaoPDO::getConexao();
            $sql = "DELETE FROM usuario WHERE id = ?";

            $stmt = $conexao->prepare($sql);

            $stmt->bindParam(1, $id);

            if($stmt->execute()){
                
            }
        }catch(Exception $ex){

        }
    }
}