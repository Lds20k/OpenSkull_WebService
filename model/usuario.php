<?php

class Usuario{
    private $id;
    private $dataNascimento;
    private $tipo;
    private $email;
    private $senha;
    private $nome;
    private $sobrenome;
    private $instituicao;
    private $imagem;
    private $biografia;

    //construtor
    function __construct($id, $dataNascimento, $tipo, $email, $senha, $nome, $sobrenome, $instituicao, $imagem, $biografia){
        $this->id = $id;
        $this->dataNascimento = $dataNascimento;
        $this->tipo = $tipo;
        $this->email = $email;
        $this->senha = $senha;
        $this->nome = $nome;
        $this->sobrenome = $sobrenome;
        $this->instituicao = $instituicao;
        $this->imagem = $imagem;
        $this->biografia = $biografia;
    }

    //Getters

    public function getId(){
        return $this->id;
    }

    public function getDataNascimento(){
        return $this->dataNascimento;
    }

    public function getTipo(){
        return $this->tipo;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getSenha(){
        return $this->senha;
    }

    public function getNome(){
        return $this->nome;
    }

    public function getSobrenome(){
        return $this->sobrenome;
    }

    public function getInstituicao(){
        return $this->instituicao;
    }

    public function getImagem(){
        return $this->imagem;
    }

    public function getBiografia(){
        return $this->biografia;
    }
    
    //Setters

    public function setId($id){
        $this->id = $id;
    }

    public function setDataNascimento($dataNascimento){
        $this->dataNascimento = $dataNascimento;
    }

    public function setTipo($tipo){
        $this->tipo = $tipo;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function setSenha($senha){
        $this->senha = $senha;
    }

    public function setNome($nome){
        $this->nome = $nome;
    }

    public function setSobrenome($sobrenome){
        $this->sobrenome = $sobrenome;
    }

    public function setInstituicao($instituicao){
        $this->instituicao = $instituicao;
    }

    public function setImagem($imagem){
        $this->imagem = $imagem;
    }

    public function setBiografia($biografia){
        $this->biografia = $biografia;
    }

    //Outros metodos

    public function converter(bool $senha = null){
        $usuario                 = new stdClass;
        $usuario->id             = $this->id;
        $usuario->dataNascimento = $this->dataNascimento;
        $usuario->tipo           = $this->tipo;
        $usuario->email          = $this->email;
        if($senha)
        $usuario->senha          = $this->senha;
        $usuario->nome           = $this->nome;
        $usuario->sobrenome      = $this->sobrenome;
        $usuario->instituicao    = $this->instituicao;
        $usuario->imagem         = $this->imagem;
        $usuario->biografia      = $this->biografia;
        return $usuario;
    }
}