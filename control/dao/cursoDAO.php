<?php

abstract class CursoDAO{
	private static $tabela = 'Curso';

	public static function inserir(Curso $curso){
		$SQL = "INSERT INTO $tabela (Criador, Nome, Imagem, Horas, Descricao, Preco) 
							 VALUES (?, ?, ?, ?, ?, ?)";
	}
}