<?php
use \Firebase\JWT\JWT;

//Usa HS256
class OpenSkullJWT{
    private static $chave = "test_key";
    private static $token = array(
        'iss' => 'http://www.openskull.web_service.com',
        'aud' => 'http://www.openskull.web_service.com',
        'iat' => 1356999524,
        'nbf' => 1357000000
    );

    //Retorna um JWT
    public static function codificar(Array $dados){
        return JWT::encode(OpenSkullJWT::$token + ['dados' => $dados], OpenSkullJWT::$chave, 'HS256');
    }

    /*
    * Decodifica o JWT
    * @param String $jwt Entrada do JSON WEB TOKEN para decodificação
    */
    public static function decodificar(String $jwt){
        try {
            return JWT::decode($jwt, OpenSkullJWT::$chave, array('HS256'));
        } catch (Exception $ex) {
            throw new Exception('JWT Invalido');
        }
    }

    /*
    * Verifica o JWT
    * @param String $jwt Entrada do JSON WEB TOKEN para verificação
    */
    public static function verificar(String $jwt){
        try {
            JWT::decode($jwt, OpenSkullJWT::$chave, array('HS256'));
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
}