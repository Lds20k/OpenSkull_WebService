<?php 
include_once 'modulo.php';

class Licao{
	private $id;
	//private $modulo;
	private $nome;
	private $conteudo;

	//construtor
	function __construct($id, /*Modulo $modulo,*/ $nome, $conteudo){
		$this->id = $id;
		//$this->modulo = $modulo;
		$this->nome = $nome;
		$this->conteudo = $conteudo;
	}

	//Getters

	public function getId(){
		return $this->id;
	}
	
	/*public function getModulo(){
		return $this->modulo;
	}*/

	public function getNome(){
		return $this->nome;
	}

	public function getConteudo(){
		return $this->conteudo;
	}

	//Setters

	public function setId($id){
		$this->id = $id;
	}

	/*public function setModulo($modulo){
		$this->modulo = $modulo;
	}*/

	public function setNome($nome){
		$this->nome = $nome;
	}

	public function setConteudo($conteudo){
		$this->conteudo = $conteudo;
	}

	//Outros metodos

	public function converter(){
		$licao              = new stdClass;
		$licao->id          = $this->id;
		//$licao->modulo      = $this->modulo->converter();
		$licao->nome        = $this->nome;
		$licao->conteudo    = $this->conteudo;

		return $licao;
	}
}