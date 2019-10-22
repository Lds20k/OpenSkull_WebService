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
	private $modulos;


	//construtor
	function __construct($id, Usuario $criador, $nome, $imagem, $horas, $descricao, $preco, Array $modulos){
		$this->id        = $id;
		$this->criador   = $criador;
		$this->nome      = $nome;
		$this->imagem    = $imagem;
		$this->horas     = $horas;
		$this->descricao = $descricao;
		$this->preco     = $preco;
		$this->modulos   = $modulos;
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

	function setModulo(Array $modulos){
		$this->$modulos = $modulos;
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

	function getModulos(){
		return $modulos;
	}

	//Outros metodos

	/*
	* Converte todos os atributos da classe
	* Curso  em  atributos de uma  stdClass
	*/
	public function converter(){
		$curso            = new stdClass;
		$curso->id        = $this->id;
		$curso->criador   = $this->criador->converter();
		$curso->nome      = $this->nome;
		$curso->imagem    = $this->imagem;
		$curso->horas     = $this->horas;
		$curso->descricao = $this->descricao;
		$curso->preco     = $this->preco;
		$curso->modulos	  = array();
		foreach ($this->modulos as $key => $modulo) {
			array_push($curso->modulos, $modulo);
		}
		return $curso;
	}
}