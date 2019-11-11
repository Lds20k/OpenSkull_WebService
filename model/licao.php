<?php 
include_once 'modulo.php';

class Licao{
	private $id;
	private $nome;
	private $conteudo;
	private $video;

	//construtor
	function __construct($id = null, $nome = null, $conteudo = null, $video = null){
		$this->id = $id;
		$this->nome = $nome;
		$this->conteudo = $conteudo;
		$this->video  = $video;
	}

	//Getters

	public function getId(){
		return $this->id;
	}

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
		$licao->nome        = $this->nome;
		$licao->conteudo    = $this->conteudo;
		$licao->video    	= $this->video;
		return $licao;
	}
}