<?php
include_once 'curso.php';

class Modulo{
	private $id;
	private $curso;
	private $nome;

	function __construct($id, Curso $curso, $nome){
		$this->id = $id;
		$this->curso = $curso;
		$this->nome = $nome;
	}

	//Getters

	public function getId(){
		return $this->id;
	}

	public function getCurso(){
		return $this->curso;
	}

	public function getNome(){
		return $this->nome;
	}

	//Setters

	public function setId($id){
		$this->id = $id;
	}

	public function setCurso(Curso $curso){
		$this->curso = $curso;
	}

	public function setNome($nome){
		$this->nome = $nome;
	}
}