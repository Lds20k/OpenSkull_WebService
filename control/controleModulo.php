 <?php
include_once 'controle.php';
include_once 'controleCurso.php';
include_once '../model/curso.php';
include_once '../model/modulo.php';



abstract class ControleModulo{
	public static function inserir($idCurso, $nome){
		try {
			$curso = ControleCurso::consultarUm($idCurso);
			$modulo = new Modulo(null, $curso, $nome);
		} catch (Exception $e) {
			
		}
	}
}