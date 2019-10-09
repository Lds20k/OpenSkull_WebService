<?php

abstract class ConexaoPDO{
    private static $serverip = "localhost";
    private static $usuario  = "root";
    private static $senha	 = "";
    private static $banco	 = "openskull";
    public static function getConexao(){
        try{
            $conexao = new PDO("mysql:host=" . ConexaoPDO::$serverip . ";dbname=" . ConexaoPDO::$banco, ConexaoPDO::$usuario, ConexaoPDO::$senha);
            $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conexao;
        }catch(PDOException $ex){
            die("A conexão ao banco falhou: " . $ex->getMessage());
        }
    }
}