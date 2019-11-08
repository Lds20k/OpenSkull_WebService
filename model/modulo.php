<?php
include_once 'licao.php';

class Modulo{
	private $id;
	private $licoes;
	private $nome;

	//construtor
	function __construct($id = null, Array $licoes = null, $nome = null){
		$this->id     = $id;
		$this->licoes = $licoes;
		$this->nome   = $nome;
	}

	//Getters

	public function getId(){
		return $this->id;
	}

	public function getLicoes(){
		return $this->licoes;
	}

	public function getNome(){
		return $this->nome;
	}

	//Setters

	public function setId($id){
		$this->id = $id;
	}

	public function setLicoes(Array $licoes){
		$this->licoes = $licoes;
	}

	public function setNome($nome){
		$this->nome = $nome;
	}

	//Outros metodos

	public function converter(){
		$modulo         = new stdClass;
		$modulo->id     = $this->id;
		$modulo->licoes = $this->licoes;
		$modulo->nome   = $this->nome;

		return $modulo;
	}
}