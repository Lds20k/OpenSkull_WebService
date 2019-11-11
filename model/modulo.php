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

	public function addLicao(Licao $licao){
		if(is_null($this->licoes))
			$this->licoes = Array();
		array_push($this->licoes, $licao);		
	}

	//Outros metodos

	public function converter(){
		$modulo         = new stdClass;
		$modulo->id     = $this->id;
		if(is_null($this->licoes))
			$modulo->licoes	= null;
		else{
			if(empty($this->licoes))
				$modulo->licoes = Array();
			else
				if($this->licoes[0] instanceof stdClass)
					$modulo->licoes = $this->licoes;
				else{
					$modulo->licoes = array();
					foreach ($this->licoes as $chave => $licao)
						array_push($modulo->licoes, $licao->converter());
				}
			$modulo->nome   = $this->nome;
		}
		return $modulo;
	}
}