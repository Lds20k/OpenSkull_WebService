<?php
include_once 'licao.php';

class Modulo{
	private $id;
	private $licao;
	private $nome;


	//construtor
	function __construct($id, Licao $licao, $nome){
		$this->id = $id;
		$this->licao = $licao;
		$this->nome = $nome;
	}

	//Getters

	public function getId(){
		return $this->id;
	}

	public function getCurso(){
		return $this->licao;
	}

	public function getNome(){
		return $this->nome;
	}

	//Setters

	public function setId($id){
		$this->id = $id;
	}

	public function setLicao(Licao $licao){
		$this->licao = $licao;
	}

	public function setNome($nome){
		$this->nome = $nome;
	}

	//Outros metodos

	public function converter(){
		$modulo        = new stdClass;
		$modulo->id    = $this->id;
		$modulo->licao = $this->licao->converter();
		$modulo->nome  = $this->nome;

		return $modulo;
	}
}