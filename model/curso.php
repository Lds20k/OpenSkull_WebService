<?php
include_once 'usuario.php';
include_once 'modulo.php';

class Curso{
	//atribustos
	private $id;
	private $criador;
	private $nome;
	private $imagem;
	private $horas;
	private $descricao;
	private $preco;
	private $modulo;


	//construtor
	function __construct($id, Usuario $criador, $nome, $imagem, $horas, $descricao, $preco, Modulo $modulo){
		$this->id        = $id;
		$this->criador   = $criador;
		$this->nome      = $nome;
		$this->imagem    = $imagem;
		$this->horas     = $horas;
		$this->descricao = $descricao;
		$this->preco     = $preco;
		$this->modulo    = $modulo;
	}


	//Setter

	function setID($id){
		$this->$id = $id;
	}

	function setCriador(Usuario $criador){
		$this->$criador = $criador;
	}

	function setNome($nome){
		$this->$nome = $nome;
	}

	function setImagem($id){
		$this->$imagem = $imagem;
	}

	function setHoras($id){
		$this->$horas = $horas;
	}

	function setDescricao($descricao){
		$this->$descricao = $descricao;
	}

	function setPreco($preco){
		$this->$preco = $preco;
	}

	function setModulo(Modulo $modulo){
		$this->$modulo = $modulo;
	}


	//Getters
	
	function getID(){
		return $id;
	}

	function getCriador(){
		return $criador;
	}

	function getNome(){
		return $nome;
	}

	function getImagem(){
		return $imagem;
	}

	function getHoras(){
		return $horas;
	}

	function getDescricao(){
		return $descricao;
	}

	function getPreco(){
		return $preco;
	}

	function getModulo(){
		return $modulo;
	}

	//Outros metodos

	public function converter(){
		$curso            = new stdClass;
		$curso->id        = $this->id;
		$curso->criador   = $this->criador->converter();
		$curso->nome      = $this->nome;
		$curso->imagem    = $this->imagem;
		$curso->horas     = $this->horas;
		$curso->descricao = $this->descricao;
		$curso->preco     = $this->preco;
		$curso->modulo     = $this->modulo->converter();
		return $curso;
	}
}