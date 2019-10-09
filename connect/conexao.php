<?php

abstract class ConexaoPDO{
    private static $serverip = "143.106.241.3";
    private static $usuario  = "cl18450";
    private static $senha	 = "cl*11082002";
    private static $banco	 = "cl18450";
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