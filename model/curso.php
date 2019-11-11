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
	function __construct($id = null, Usuario $criador = null, $nome = null, $imagem = null, $horas = null, $descricao = null, $preco = null, Array $modulos = null){
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

	public function setID($id){
		$this->id = $id;
	}

	public function setCriador(Usuario $criador){
		$this->criador = $criador;
	}

	public function setNome($nome){
		$this->nome = $nome;
	}

	public function setImagem($id){
		$this->imagem = $imagem;
	}

	public function setHoras($id){
		$this->horas = $horas;
	}

	public function setDescricao($descricao){
		$this->descricao = $descricao;
	}

	public function setPreco($preco){
		$this->preco = $preco;
	}

	public function setModulo(Array $modulos){
		$this->modulos = $modulos;
	}

	public function addModulo(Modulo $modulo){
		if(!is_array($this->modulos)){
			$this->modulos = Array();
		}
		array_push($this->modulos, $modulo);
	}


	//Getters
	
	public function getID(){
		return $this->id;
	}

	public function getCriador(){
		return $this->criador;
	}

	public function getNome(){
		return $this->nome;
	}

	public function getImagem(){
		return $this->imagem;
	}

	public function getHoras(){
		return $this->horas;
	}

	public function getDescricao(){
		return $this->descricao;
	}

	public function getPreco(){
		return $this->preco;
	}

	public function getModulos(){
		return $this->modulos;
	}

	//Outros metodos

	/*
	* Converte todos os atributos da classe
	* Curso  em  atributos de uma  stdClass
	*/
	public function converter(){
		$curso            = new stdClass;
		$curso->id        = $this->id;
		if(is_null($this->criador))
			$curso->criador = null;
		else
			$curso->criador   = $this->criador->converter();
		$curso->nome      = $this->nome;
		$curso->imagem    = $this->imagem;
		$curso->horas     = $this->horas;
		$curso->descricao = $this->descricao;
		$curso->preco     = $this->preco;
		if(is_null($this->modulos))
			$curso->modulos	= null;
		else{
			if(empty($this->modulos))
				$curso->modulos	= Array();
			else
				if($this->modulos[0] instanceof stdClass)
					$curso->modulos = $this->modulos;
				else{
					$curso->modulos	= array();
					foreach ($this->modulos as $key => $modulo)
						array_push($curso->modulos, $modulo->converter());
				}
		}
		return $curso;
	}
}