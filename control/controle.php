<?php 
//Classe abstrata para implementação de
//Metodos padrão de controle
abstract class Controle{
	//Insere um objeto ao banco
	abstract public static function inserir();
	//Atualiza um objeto ao banco
	abstract public static function atualizar();
	//Retorna um array com os objetos do banco
	abstract public static function consultar();
	//Retorna um objeto do banco
	abstract public static function consultarUm();
	//Deleta um objeto do banco
	abstract public static function deletar();
}