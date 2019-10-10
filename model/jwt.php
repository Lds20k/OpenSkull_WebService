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
    private $dados;

    //Entrar com um array associativo
    function __construct(Array $dados){
        $this->dados = $dados;
    }

    //Retorna um JWT
    function get(){
        return JWT::encode(OpenSkullJWT::$token + $this->dados, OpenSkullJWT::$chave, 'HS256');
    }

    /*
    * Verifica o JWT
    * @param String $jwt Entrada o JSON WEB TOKEN para verificação
    */
    function decodificar(String $jwt){
        try {
            return JWT::decode($jwt, $chave, array('HS256'));
        } catch (Exception $ex) {
            throw new Exception('JWT Invalido');
        }
    }
}